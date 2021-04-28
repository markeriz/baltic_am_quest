<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
        Pateikiama prisijungimo forma;
    */
    public function login()
    {
        return view('auth.login');
    }

    /*
        Vykdomas pateiktų duomenų tikrinimas ir jeigu viskas tinka
        patikrinama ar toks vartotojas yra registruotas sistemoje.
        Jeigu viskas gerai jis siunčiamas į adresų knygelių sąrašą;
    */
    public function check(LoginRequest $request)
    {
        if(Auth::attempt($request->validated()))
        {
            return redirect()->route('address_books.index');
        }

        return back();
    }

    /*
        Atjungiamas vartotojas nuo sistemos;
    */
    public function logout()
    {
        Auth::logout();
        session()->invalidate();

        return redirect()->route('login');
    }
}
