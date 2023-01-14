<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Exception;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function createCuti(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'keterangan' => 'required',
            'judul' => 'required',
            'tanggal' => 'required',
        ]);


        $cuti = Cuti::create([
            'user_id' => $request->user_id,
            'keterangan' => $request->keterangan,
            'judul' => $request->judul,
            'tanggal' => $request->tanggal
        ]);


        $cuti = Cuti::with(['user'])->find($cuti->id);

        try {
            $cuti->save();
            return ResponseFormmater::success(
                $cuti,
                'Data Cuti Berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Data Cuti gagal ditambahkan',
                505
            );
        }

    }

    public function getCuti (Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $user_id = $request->input('user_id');


        if($id) {
            $cuti = Cuti::with(['user'])->find($id);

            if($cuti) {
                return ResponseFormmater::success(
                    $cuti,
                    'Data Cuti berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Tidak ada data Cuti',
                    505
                );
            }
        }


        $cuti = Cuti::with(['user']);

        if($user_id) {
            $cuti->where('user_id', $user_id);
        }

        return ResponseFormmater::success(
            $cuti->paginate($limit),
            'Data List Penilayan berhasil diambil'
        );
    }

    public function updateCuti (Request $request, $id) {
        $cuti = Cuti::with(['user'])->findOrFail($id);
        $cuti->update($request->all());

        return ResponseFormmater::success(
            $cuti,
            'Data Cuti Berhasil diupdate'
        );
    }

    public function deleteCuti (Request $request, $id) {
        $cuti = Cuti::with(['user'])->findOrFail($id);
        $cuti->delete($request->all());

        return ResponseFormmater::success(
            $cuti,
            'Data Cuti Berhasil delete'
        );
    }
}
