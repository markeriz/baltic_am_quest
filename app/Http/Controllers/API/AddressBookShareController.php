<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AddressBook;
use App\Models\AddressBookShare;
use App\Models\User;
use Illuminate\Http\Request;

class AddressBookShareController extends Controller
{
    /*
        Pateikiama registruotam vartotojui visos adresų
        knygelės kurios pažymėtos kaip dalintis su juo;
    */
    public function index()
    {
        $shares_with_user = auth()->user()->address_book_shares;

        return response()->json($shares_with_user, 200);
    }

    /*
        Pateikiamas sąrašas sistemos vartotojų su kurias yra
        galimybė dalintis;
    */
    public function show_users($id)
    {
        // Gaunami vartotojai su kuriais jau yra dalijimasi
        $shares_with = AddressBook::where([
                            'user_id' => auth()->user()->id,
                            'id' => $id
                        ])
                        ->firstOrFail()
                        ->address_book_shares()
                        ->pluck('user_id')
                        ->toArray();

        // Pridedamas pats autentifikuotas vartotojas
        array_push($shares_with, auth()->user()->id);

        // Gaunami galimi vartotojai su kuriais galima dalintis knygele.
        $users = User::whereNotIn('id', $shares_with)
                    ->get();

        return response()->json($users, 200);
    }

    /*
        Sukuriamas įrašas, kad adresų knygelė yra dalijimasi su
        kitu sistemos vartotoju;
    */
    public function store(Request $request, $address_book, User $user)
    {
        $ab = $this->address_book($address_book)->firstOrFail();

        // Jeigu adresų knygelė priskiriama antrą kartą tam pačiam vartotojui,
        // arba bandoma dalintis su pačiu savimi, arba dalijimasi ne savo adresu
        // knygele, gryžtama atgal.
        if ($ab->address_book_shares()
                ->where(['user_id' => $user->id])
                ->first() ||
            auth()->user()->id == $user->id ||
            $ab->user_id == auth()->user()->id)
        {
            return response()->json([
                'message' => 'With this user you cant share, because already shared with him!'
            ], 200);
        }

        $ab->address_book_shares()->create(['user_id' => $user->id]);

        return response()->json([
            'message' => 'Successfully shared!'
        ], 200);
    }

    /*
        Dalijimasi gali panaikinti tiek pasidalines vartotojas
        tiek kuriam leista matyti addresą. Tik šioje vietoje
        nepadarytas tikrinimas ar įrašas priklauso savininkui ir
        ar įrašas yra dalijimasi su tuo asmeniu kuris nori panaikinti;
    */
    public function destroy($id)
    {
        $user_id = auth()->user()->id;

        AddressbookShare::where([
            'user_id' => $user_id,
            'id' => $id
        ])
        ->orWhereHas('address_book', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })
        ->firstOrFail()->delete();

        return response()->json([
            'message' => 'Successfully canceled!'
        ], 200);
    }

    /*
        Pateikia adresų knygelę kuri priklauso autorizuotam vartotojui;
    */
    private function address_book($id)
    {
        return AddressBook::where([
            'user_id' => auth()->user()->id,
            'id' => $id
        ]);
    }
}
