<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.index')->with([
            'title' => 'Login'
        ]);
    }
    public function create()
    {
//        dd("test");
        return view('auth.daftar')->with([
            'title' => 'Daftar'
        ]);
    }
    public function store(Request $request)
    {

//        dd($request->all());
//        $validateData = $request->validate([
//            'name'      => 'required|min:3|max:50',
//            'email'     => 'required|email|unique:users',
////            'password'  => 'required|min:6|confirmed',
////            'password_confirmation' => 'required|min:6',
////            'nip' => 'required|numeric|unique:App\Models\User,nip'
//        ]);

//        dd($validateData['nip']);
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'nip' => $request->input('nip'),
            'jabatan' => $request->input('jabatan'),
            'password' => Hash::make($request->input('password'))
        ]);



        $request->session()->flash('success', "Daftar Berhasil! Please Login");
        return redirect()->route('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('menu.home'))->with('success', 'Selamat datang kembali ' . Auth::user()->nama);
        }
        return back()->with('error', 'Email atau Password Salah')->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('auth.index'));
    }
}
