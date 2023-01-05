<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Exception;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function createPengaturan(Request $request) {

        $request->validate([
            'cabang' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'radius' => 'required|numeric',
            'user_id' => 'required|exists:users,id'
        ]);

        $pengaturan = Pengaturan::create([
            'cabang' => $request->cabang,
            'lat' => $request->lat,
            'long' => $request->long,
            'radius' => $request->radius,
            'user_id' => $request->user_id,
            'shift' => $request->shift,
        ]);

        $pengaturan = Pengaturan::with(['user'])->find($pengaturan->id);

        try {
            $pengaturan->save();
            return ResponseFormmater::success(
                $pengaturan,
                'Data Pengaturan Absen berhasil dibuat'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                404
            );
        }
    }

    public function getPengaturan (Request $request) {
        $id = $request->input('id');
        $cabang = $request->input('cabang');


        if($id) {
            $pengaturan = Pengaturan::with(['user'])->find($id);

            if($pengaturan) {
                return ResponseFormmater::success(
                    $pengaturan,
                    'Data Pengaturan Berhasil di ambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data Pengaturan tidak ada',
                    404
                );
            }
        }

        $pengaturan = Pengaturan::with(['user']);

        if($cabang) {
            $pengaturan->where('cabang', 'like', '%' . $cabang . '%');
        }

        return ResponseFormmater::success(
            $pengaturan->get(),
            'Data List Pengaturan Berhasil diambil'
        );
    }

    public function updatePengaturan (Request $request, $id) {
        $pengaturan = Pengaturan::with(['user'])->findOrFail($id);
        $data = $request->all();

        $pengaturan->update($data);
        return ResponseFormmater::success(
            $pengaturan,
            'Data Pengaturan Berhasil di update'
        );
    }

    public function deletePengaturan (Request $request, $id) {
        $pengaturan = Pengaturan::with(['user'])->findOrFail($id);
        $data = $request->all();

        $pengaturan->delete($data);
        return ResponseFormmater::success(
            $pengaturan,
            'Data Pengaturan Berhasil di Delete'
        );
    }
}
