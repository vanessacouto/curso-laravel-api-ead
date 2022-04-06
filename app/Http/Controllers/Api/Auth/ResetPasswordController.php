<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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

    public function resetPassword(Request $request)
    {
        // validações
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|max:15',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password) // criptografa a senha do usuario
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user)); // esse evento por si só não fará nada...mas poderiamos escrever um
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)], 422);
    }
}
