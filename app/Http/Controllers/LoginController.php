<?php

namespace App\Http\Controllers;

use App\Token;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
}
