<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        try {
            $data = DB::table('users')
                ->where('email', $request->email)
                ->limit(1)
                ->get();


//        dd($data[0]->jabatan);

            if ( $data[0]->jabatan != 'admin'){
                return back()->with('error', 'Anda Bukan Admin')->onlyInput('email');
            }

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('menu.home'))->with('success', 'Selamat datang kembali ' . Auth::user()->nama);
            }
            return back()->with('error', 'Email atau Password Salah')->onlyInput('email');
        }catch (\Exception $e){
            return back()->with('error', 'Email atau Password Salah'.$e)->onlyInput('email');
        }


    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('auth.index'));
    }




}
