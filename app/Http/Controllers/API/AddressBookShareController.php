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
        $shares_with = $this->get_address_book($id)->address_book_shares()->pluck('user_id')->toArray();
        array_push($shares_with, auth()->user()->id);
        $users = User::whereNotIn('id', $shares_with)->get();

        return response()->json($users, 200);
    }

    /*
        Sukuriamas įrašas, kad adresų knygelė yra dalijimasi su
        kitu sistemos vartotoju;
    */
    public function store(Request $request, $address_book, User $user)
    {
        $ab = $this->get_address_book($address_book);

        if ($ab->address_book_shares()->where(['user_id' => $user->id])->first())
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
    public function destroy(AddressBookShare $address_book_share)
    {
        $address_book_share->delete();
        return response()->json([
            'message' => 'Successfully canceled!'
        ], 200);
    }

    /*
        Pateikia adresų knygelę kuri priklauso autorizuotam vartotojui;
    */
    private function get_address_book($id)
    {
        return AddressBook::where([
            'user_id' => auth()->user()->id,
            'id' => $id
        ])->firstOrFail();
    }
}
