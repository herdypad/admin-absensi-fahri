<?php

namespace App\Http\Controllers;

use App\Http\Resources\PresensiInit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Presensi;



class DataAbsenController extends Controller
{


    // ----------------------------------------- S T A R T  - P R E S E N S I --------------------------------------------//

    public function dataPresensi(Request $request){

        $data = DB::table('presensis')
            ->join('users', 'presensis.user_id', '=', 'users.id')
            ->get();

//        dd($data[0]->name);

        return view ('admin.rekap.DataAbsensi')->with([
            'title' => 'Data Presensi',
            'absen' => $data,

        ]);
    }






}
