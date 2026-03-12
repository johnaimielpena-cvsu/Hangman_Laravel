<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function show(){
        if (auth()->check()){
            return redirect()->route('games.index');
        }
        return view('login.show');
    }

    public function store(AuthLoginRequest $request){
        $credentials = $request->only('email' , 'password');

        if (!Auth::attempt($credentials)){
            return back()->withErrors([
                'password' => 'Incorrect Password',
            ])->withInput();
        }

        $request->session()->regenerate();
        return redirect()->route('games.index');
    }

    public function destroy(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login.show');
    }
    
}
