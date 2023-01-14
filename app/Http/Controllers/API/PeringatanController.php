<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Peringatan;
use Exception;
use Illuminate\Http\Request;

class PeringatanController extends Controller
{
    public function createPeringatan (Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_sp' => 'required',
            'keterangan' => 'required',
            'name_admin' => 'required|string|max:255',
            'tanggal_dibuat' => 'required|string|max:255',
            'tanggal_berlaku' => 'required|string|max:255',
        ]);


        $peringatan = Peringatan::create([
            'user_id' => $request->user_id,
            'category_sp' => $request->category_sp,
            'keterangan' => $request->keterangan,
            'name_admin' => $request->name_admin,
            'tanggal_dibuat' => $request->tanggal_dibuat,
            'tanggal_berlaku' => $request->tanggal_berlaku,
        ]);


        $peringatan = Peringatan::with(['user'])->find($peringatan->id);

        try {
            $peringatan->save();
            return ResponseFormmater::success(
                $peringatan,
                'Data Peringatan Berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Data Peringatan gagal ditambahkan',
                505
            );
        }

    }

    public function getPeringatan (Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $user_id = $request->input('user_id');


        if($id) {
            $peringatan = Peringatan::with(['user'])->find($id);

            if($peringatan) {
                return ResponseFormmater::success(
                    $peringatan,
                    'Data Peringatan berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Tidak ada data Peringatan',
                    505
                );
            }
        }


        $peringatan = Peringatan::with(['user']);

        if($user_id) {
            $peringatan->where('user_id', $user_id);
        }

        return ResponseFormmater::success(
            $peringatan->paginate($limit),
            'Data List Peringatan berhasil diambil'
        );
    }

    public function updatePeringatan (Request $request, $id) {
        $peringatan = Peringatan::with(['user'])->findOrFail($id);
        $peringatan->update($request->all());

        return ResponseFormmater::success(
            $peringatan,
            'Data Peringatan Berhasil diupdate'
        );
    }

    public function deletePeringatan (Request $request, $id) {
        $peringatan = Peringatan::with(['user'])->findOrFail($id);
        $peringatan->delete($request->all());

        return ResponseFormmater::success(
            $peringatan,
            'Data Peringatan Berhasil delete'
        );
    }
}
