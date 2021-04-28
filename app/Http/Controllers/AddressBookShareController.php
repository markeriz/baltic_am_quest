<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use App\Models\AddressbookShare;
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

        return view('share.address_book.address_books_shares_list', compact('shares_with_user'));
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

        return view('share.address_book.users_list', compact('users'));
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
            return back();
        }

        $ab->address_book_shares()->create(['user_id' => $user->id]);

        return back();
    }

    /*
        Dalijimasi gali panaikinti tiek pasidalines vartotojas
        tiek kuriam leista matyti addresą;
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

        return back();
    }

    private function address_book($id)
    {
        return AddressBook::where([
            'user_id' => auth()->user()->id,
            'id' => $id
        ]);
    }
}
