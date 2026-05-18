<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cpf' => 'required|size:14',
            'password' => 'required',
        ])->stopOnFirstFailure();

        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $credencials = [
                'cpf' => $request->cpf,
                'password' => $request->password,
                'is_active' => true,
            ];

            if (Auth::attempt($credencials)) {
                $request->session()->regenerate();
                return redirect('/dashboard');
            } else {
                return back()->withErrors([
                    'cpf' => 'CPF ou senha incorretos',
                ]);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
