<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveRegistrationRequest;
use App\Models\User;

class RegistrationController extends Controller
{
    //
    public function show(){
        return view('registration.show');
    }

    public function store(SaveRegistrationRequest $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login.show');
    }
}
