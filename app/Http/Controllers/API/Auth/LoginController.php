<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
        Vykdomas pateiktų duomenų tikrinimas ir jeigu viskas tinka
        patikrinama ar toks vartotojas yra registruotas sistemoje.
        Jeigu viskas gerai siunčiamas atsakymas su vartotojo duomenimis
        ir sukurtu nauju raktu;
    */
    public function check(LoginRequest $request)
    {
        if(!Auth::attempt($request->validated()))
        {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        return response([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ], 200);
    }

    /*
        Atjungiamas vartotojas nuo sistemos, panaikinamas raktas
        iš duomenų bazės;
    */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logout successfully!'
        ], 200);;
    }
}
