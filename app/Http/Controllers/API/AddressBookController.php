<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressBookStoreUpdateRequest;
use App\Models\AddressBook;

class AddressBookController extends Controller
{
    /*
        Pateikiama registruotam vartotojui visos adresų
        knygelės kurios jam priklauso;
    */
    public function index()
    {
        $address_books = auth()->user()->address_books;
        return response()->json($address_books, 200);
    }

    /*
        Vykdomas pateiktų duomenų tikrinimas ir jeigu viskas tinka
        išsaugojamas duomenų bazėje. Šioje vietoje sudirba "AddressBookObserver"
        klasė, kuomet prieš saugojima įrašomas įrašo savininkas;
    */
    public function store(AddressBookStoreUpdateRequest $request)
    {
        $address_book = AddressBook::create($request->validated());
        return response()->json($address_book, 200);
    }

    /*
        Pateikiama adresų knygelė registruotam vartotojui su
        patikrinimu ar tikrai vartotojui priklauso šis įrašas.
        Jeigu viskas gerai, duomenys yra pateikiami su knygelės ryšiais;
    */
    public function show($id)
    {
        $address_book = AddressBook::with('address_book_shares.user')->where([
            'user_id' => auth()->user()->id,
            'id' => $id
        ])->firstOrFail();

        return response()->json($address_book, 200);
    }

    /*
        Vykdomas pateiktų duomenų tikrinimas ir jeigu viskas tinka
        patikrinama ar įrašas priklauso autoriui ir išsaugojamas duomenų bazėje;
    */
    public function update(AddressBookStoreUpdateRequest $request, $id)
    {
        $address_book = $this->get_address_book($id);
        $address_book->update($request->validated());

        return response()->json($address_book, 200);
    }

    /*
        Adresų knygelės panaikinimas jeigu adresų knygelės įrašas
        priklauso autoriui ir taip pat panaikinami visi dalijimaisi
        knygelės įrašu;
    */
    public function destroy($id)
    {
        $address_book = $this->get_address_book($id);
        $address_book->address_book_shares()->delete();
        $address_book->delete();

        return response()->json([
                'message' => 'Deleted successfully!'
            ], 200);
    }

    /*
        Pateikia adresų knygelę kuri priklauso autorizuotam vartotojui;
    */
    private function get_address_book($id)
    {
        return AddressBook::with('address_book_shares.user')->where([
            'user_id' => auth()->user()->id,
            'id' => $id
        ])->firstOrFail();
    }
}
