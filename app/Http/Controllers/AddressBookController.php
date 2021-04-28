<?php

namespace App\Http\Controllers;

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
        return view('address_book.index', compact('address_books'));
    }

    /*
        Pateikiama naujos knygelės sukurimui skirta forma;
    */
    public function create()
    {
        return view('address_book.create');
    }

    /*
        Vykdomas pateiktų duomenų tikrinimas ir jeigu viskas tinka
        išsaugojamas duomenų bazėje. Šioje vietoje sudirba "AddressBookObserver"
        klasė, kuomet prieš saugojima įrašomas įrašo savininkas;
    */
    public function store(AddressBookStoreUpdateRequest $request)
    {
        AddressBook::create($request->validated());

        return redirect()->route('address_books.index');
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

        return view('address_book.show', compact('address_book'));
    }

    /*
        Pateikiama adresų knygelė registruotam vartotojui su
        patikrinimu ar tikrai vartotojui priklauso šis įrašas.
        Jeigu viskas gerai, duomenys yra pateikiami su knygelės ryšiais;
    */
    public function edit($id)
    {
        $address_book = $this->get_address_book($id);

        return view('address_book.edit', compact('address_book'));
    }

    /*
        Vykdomas pateiktų duomenų tikrinimas ir jeigu viskas tinka
        patikrinama ar įrašas priklauso autoriui ir išsaugojamas duomenų bazėje;
    */
    public function update(AddressBookStoreUpdateRequest $request, $id)
    {
        $address_book = $this->get_address_book($id);
        $address_book->update($request->validated());

        return redirect()->route('address_books.index');
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

        return redirect()->route('address_books.index');
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
