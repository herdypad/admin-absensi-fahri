<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use App\Models\User;
use App\Models\Cabang;
use App\Models\Jabatan;
use App\Models\Pegawai;

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

//        dd($request->all());

        //file upload
        $file = Request()->file('foto');
//        dd($file);
        $date = (string)date('ymdhis');
        $fileName ='master-'. $date . $file->getClientOriginalName();         /// untuk Presensi
        $file->move('presensi_file/', $fileName);

        User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'foto' => $fileName,
            // default password jika admin menambahkan pegawai secara manual
            'password' => Hash::make('password'),
        ]);

        return redirect()->route('pegawai')->with('pesan',"Penambahan Data {$request['nama']} berhasil" );
    }


    public function updatePegawai(Request $request, $id)
    {
        User::where('id', $request->id)
        ->update([
            'nama'       => $request->nama,
            'email'      => $request->email,
        ]);

        Pegawai::where('user_id',$request->id)
        ->update([
            'nip'        => $request->nip,
            'tgl_lahir'  => $request->tgl_lahir,
            'j_k'        => $request->j_k,
            'no_tlp'     => $request->no_tlp,
            'alamat'     => $request->alamat,
            'jabatan_id' => $request->jabatan_id,
            'cabang_id'  => $request->cabang_id,
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
