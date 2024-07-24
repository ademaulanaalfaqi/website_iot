<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login()
    {
        return view('admin.login');
    }

    public function loginProses(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/beranda');
        } else {
            return back()->with('danger', 'Mohon periksa username dan password anda.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    protected function username()
    {
        return 'username';
    }
}
