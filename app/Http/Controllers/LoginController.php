<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login($token)
    {   
        $token = Token::findActive($token);
        
        if ($token == null) {
            alert('Este enlace ya expiró, por favor solicite un nuevo token', 'danger');

            return redirect()->route('token');
        }

        $token->login();

        return redirect('/');
    }
    
    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
        
        alert('Hasta pronto!');

        return redirect('/');

    }
}
