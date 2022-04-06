<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(AuthRequest $request)
    {
        // recuperar o usuario atraves do email
        $user = User::where('email', $request->email)->first();

        // se nao recuperar o usuario ou a senha não bater com a do banco de dados
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // // pode receber um parametro na request (no nosso caso o 'logout_others_devices')
        // if($request->has('logout_others_devices')) {
        //     //deleta todos os tokens do usuário
        //     $user->tokens()->delete();
        // }

        $user->tokens()->delete(); // funciona como uma espécie de 'logout', nao conseguindo usar o mesmo token novamente
        
        // cria o token
        $token = $user->createToken($request->device_name)->plainTextToken;

        // retorna o toke criado
        return response()->json([
            'token' => $token
        ]);
    }
}
