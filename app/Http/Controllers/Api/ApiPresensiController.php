<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PresensiInit;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiPresensiController extends Controller
{
    public function dataPresensiApi($id){
        $data = DB::table('presensis')->where('user_id', $id)->get();
        return new PresensiInit(true, 'Berhasil', $data);
    }

    public function dataPresensiToday($id){
        $today = date('Ymd');
        $data = DB::table('presensis')
            ->where('user_id', $id)
            ->where('tgl_presensi', $today)
            ->get();
        return new PresensiInit(true, 'Berhasil', $data);
    }

    public function absen(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return new PresensiInit(false, 'Validasi Gagal', $validator->errors()->first());
        }

        $datenow = date('Y-m-d');
        $data = DB::table('presensis')
            ->where('user_id', $request->user_id)
            ->where('tgl_presensi',$datenow)
            ->limit(1)
            ->get();

        if ($data->isEmpty()){
            //file upload
            $file = Request()->file('file');
            $date = (string)date('ymdhis');
            $fileName ='masuk-'. $date . $file->getClientOriginalName();         /// untuk Presensi
            $file->move('presensi_file/', $fileName);                        /// untuk local
            $photoUrl =  url('api/file/' . $fileName);


            // Buat entri baru di tabel absensi
            Presensi::create([
                'user_id' => $request->input('user_id'),
                'tgl_presensi' => date('Y-m-d'),
                'jam_masuk' => date('H:i:s'),
                'jam_pulang' => null,
                'foto_masuk' => $fileName,
                'foto_pulang' => '',
                'ket' => $request->input('ket'),
            ]);

            return response()->json([
                'status' => 'succes',
                'message' => 'Absen Masuk Berhasil',

            ], 200);
        }else{
            //file upload
            $file = Request()->file('file');
            $date = (string)date('ymdhis');
            $fileName ='pulang-'. $date . $file->getClientOriginalName();         /// untuk Presensi
            $file->move('presensi_file/', $fileName);                        /// untuk local


            // Buat entri baru di tabel absensi
            Presensi::where('id', $data[0]->id)->update([
                'jam_pulang' => date('H:i:s'),
                'foto_pulang' => $fileName,
                'ket' => $request->input('ket'),
            ]);

            return response()->json([
                'status' => 'succes',
                'message' => 'Absen Pulang Berhasil',

            ], 200);
        }
    }




}
