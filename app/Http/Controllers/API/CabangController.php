<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Exception;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function createCabang(Request $request) {
        $request->validate([
            'name_cabang' => 'required|string|max:255'
        ]);

       $cabang = Cabang::create([
            'name_cabang' => $request->name_cabang
       ]);

       try {
            $cabang->save();
            return ResponseFormmater::success(
                $cabang,
                'Data cabang berhasil di buat'
            );
       }

       catch(Exception $error) {
            return ResponseFormmater::error(
                null,
                'data cabang gagal dibuat',
                404
            );
       }
    }

    public function updateCabang(Request $request, $id) {
        $cabang = Cabang::findOrFail($id);
        $data = $request->all();

        $cabang->update($data);
        return ResponseFormmater::success(
            $cabang,
            'Data cabang berhasil di update'
        );
    }

    public function deleteCabang(Request $request, $id) {
        $cabang = Cabang::findOrFail($id);
        $data = $request->all();

        $cabang->delete($data);
        return ResponseFormmater::success(
            $cabang,
            'Data cabang berhasil di Delete'
        );
    }

    public function getCabang(Request $request) {
        $id = $request->input('id');

        if($id) {
            $cabang = Cabang::find($id);

            if($cabang) {
                return ResponseFormmater::success(
                    $cabang,
                    'Data Cabang Berhasil dibuat'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data Cabang gagal dibuat',
                    404
                );
            }
        }

        $cabang = Cabang::query();

        return ResponseFormmater::success(
            $cabang->get(),
            'Data Cabang Berhasil diambil'
        );
    }
}
