<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        $data = [
            'title' => 'Register',
        ];
        return view('auth.register.index', $data);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'min:5', 'max:255'],
            'nim' => ['required', 'max:10', 'unique:users']
        ]);

        // TAMBAHAN
        $isAdmin = $request->has('isAdmin') ? 1 : 0;

        $validatedData['isAdmin'] = $isAdmin;

        // TAMBAHAN
        $validatedData['password'] = Hash::make($validatedData['password']);

        // PROSES PENYIMPANAN KE DATABASE
        User::create($validatedData);

        return redirect('/login')->with('success', 'Registration successfull! Please login');
    }
}
