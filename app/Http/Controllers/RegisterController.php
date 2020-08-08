<?php

namespace App\Http\Controllers;

use App\{Token, User};
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'email' => ['required','email','unique:users,email'],
            'username' => 'required|unique:users,username',
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $user = User::create($request->all());

        Token::generateFor($user)->sendByEmail();

        alert('Gracias por registrarte, Te enviamos un enlace a tu correo para que inicies sesión');

        return back();
    }
}
