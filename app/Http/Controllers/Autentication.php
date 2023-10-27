<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Autentication extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect('/'); // Ubah rute tujuan jika autentikasi gagal
        }

        session(['user' => $user, 'token' => $user->createToken('jhon_user')->plainTextToken]);


        return redirect('/transaction_data');
    }
}
