<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use App\Models\User;


class MenuAdminController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('admin');
//    }

    // --------------------------------------------- S T A R T  - A D M I N -----------------------------------------------//

    public function admin()
    {
        $admin = User::where('role', 'Admin')->paginate(5);
        return view('admin.admin')->with([
            'title' => 'Data User',
            'admin' => $admin,
        ]);
    }



    // -------------------------------------------- S T A R T  - P E G A W A I ----------------------------------------------//

    public function pegawai(Request $request)
    {

        $pegawai = User::all();
//        dd($pegawai[0]->foto);
         return view('admin.pegawai', compact('pegawai'))->with([
             'title' => 'Data User',
             'admin' => $pegawai,
         ]);




    }


    public function createPegawai(Request $request)
    {
        //file upload
        $file = Request()->file('foto');
        $fileName ='master-'. $request->email . "." . $file->getClientOriginalExtension();         /// untuk Presensi
        $file->move('presensi_file/', $fileName);

//        dd($fileName);

      $user =  User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'foto'  => $fileName,
            'password' => Hash::make('password'),
        ]);

        User::where('id', $user->id)
            ->update([
                'foto'       => $fileName,
            ]);


        return redirect()->route('pegawai')->with('pesan',"Penambahan Data {$request['nama']} berhasil" );
    }


    public function updatePegawai(Request $request, $id)
    {

        //file upload
        if (!empty(Request()->file('foto'))){
            $file = Request()->file('foto');
            $fileName ='master-'. $request->email . "." . $file->getClientOriginalExtension();
            $file->move('presensi_file/', $fileName);

            User::where('id', $id)
                ->update([
                    'foto'       => $fileName,
                ]);
        }

        User::where('id', $request->id)
        ->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'password' => Hash::make('password'),
        ]);

        session()->flash('pesan',"Perubahan Data {$request['nama']} berhasil");
        return redirect()->route('pegawai');

    }


    public function updatePegawaiPassword(Request $request, $id)
    {
        User::where('id', $request->id)
        ->update([
            'password'       => Hash::make($request['password']),
        ]);

        session()->flash('pesan',"Perubahan Password {$request->name} berhasil");
        return redirect()->route('pegawai');

    }


    public function deletePegawai($id)
    {
        $user = User::where('id',$id)->first();
        $user->delete();
        return redirect()->route('pegawai')->with('pesan',"Data berhasil dihapus" );
    }

    // ------------------------------------------------ E N D  - P E G A W A I ------------------------------------------------//
}
