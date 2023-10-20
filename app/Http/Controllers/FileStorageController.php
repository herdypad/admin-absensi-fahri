<?php

namespace App\Http\Controllers;


use Exception;

class FileStorageController extends Controller
{

    /**
     * @OA\GET(
     *     path="/api/file/{FILE}",
     *     tags={"FILE STORAGE"},
     *     summary="File",
     *     description="Liat File",
     *     operationId="show_file",
     *     @OA\Parameter(
     *          name="FILE",
     *          in="path",
     *
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function DownloadFile($FILE)
    {


        try{
            $content = 'presensi_file/'.$FILE;
            return response()->file($content);

        }catch(Exception $e){
            return response()->json([
                'message' => 'Data Tidak Ditemukan'
            ], 204);
        }

    }





}

