<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Keterangan;
use Exception;
use Illuminate\Http\Request;

class KeteranganController extends Controller
{
    public function createKeterangan(Request $request) {

        $request->validate([
            'keterangan' => 'required',
            'photo_bukti' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $keterangan = Keterangan::create([
            'keterangan' => $request->keterangan,
            'photo_bukti' => $request->photo_bukti
        ]);

        if($request->file('photo_bukti')->isValid()) {
            $nameBukti = $request->file('photo_bukti');
            $extensions = $nameBukti->getClientOriginalExtension();
            $buktiUpload = "bukti/" .\date('YmdHis').".".$extensions;
            $buktiPath = \env('UPLOAD_PATH'). "/bukti";
            $request->file('photo_bukti')->move($buktiUpload, $buktiPath);
            $keterangan['photo_bukti'] = $buktiUpload;
        }

        try {
            $keterangan->save();
            return ResponseFormmater::success(
                $keterangan,
                'Data Keterangan Berhasil dibuat'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                null,
                'Data Keterangan gagal di upload',
                404
            );
        }
    }

    public function getKeterangan (Request $request) {
        $id = $request->input('id');

        if($id) {
            $keterangan = Keterangan::find($id);

            if($keterangan) {
                return ResponseFormmater::success(
                    $keterangan,
                    'Data Keterangan berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data Keterangan gagal diambil',
                    404
                );
            }
        }

        $keterangan = Keterangan::query();

        return ResponseFormmater::success(
            $keterangan->get(),
            'Data List keterangan berhasil diambil'
        );
    }
}
