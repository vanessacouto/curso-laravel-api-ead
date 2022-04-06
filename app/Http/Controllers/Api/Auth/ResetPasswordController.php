<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        // valida que realmente recebeu um email
        $request->validate(['email' => 'required|email']);

        // dispara uma notificacao no email
        $status = Password::sendResetLink($request->only('email')); // o 'only' cria um 'array' com o nosso 'email'

        //se retornar o status 'PASSWORD_RESET', tudo deu ok
        return $status === Password::PASSWORD_RESET
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)], 422);
    }
}
