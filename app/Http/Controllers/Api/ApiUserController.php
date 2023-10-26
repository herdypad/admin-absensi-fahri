<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PresensiInit;
use App\Models\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function ajukanFoto (Request $request)
    {

        //file upload
        $file = Request()->file('file');
        $date = (string)date('ymdhis');
        $fileName ='master-'. $date . $file->getClientOriginalName();         /// untuk Presensi
        $file->move('presensi_file/', $fileName);

        User::where('id', $request->user_id)
            ->update([
                'foto'       => $fileName,
            ]);
        return new PresensiInit(true, 'Berhasil', "Update Berhasil");

    }


}
