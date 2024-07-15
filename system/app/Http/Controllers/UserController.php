<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index()
    {
        $data['list_pengguna'] = User::all();

        return view('admin.pengguna', $data);
    }

    function store()
    {
        $pengguna = new User();
        $pengguna->nama = request('nama');
        $pengguna->username = request('username');
        $pengguna->password = bcrypt(request('password'));
        $pengguna->save();

        return redirect('pengguna');
    }

    function update(User $id)
    {
        $id->nama = request('nama');
        $id->username = request('username');
        if (request('password')) $id->password = bcrypt(request('password'));
        $id->save();

        return redirect('pengguna');
    }

    function delete(User $id)
    {
        $id->delete();

        return redirect('pengguna');
    }
}
