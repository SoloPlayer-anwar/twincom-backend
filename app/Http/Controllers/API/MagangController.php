<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Magang;
use Exception;
use Illuminate\Http\Request;

class MagangController extends Controller
{
    public function createMagang(Request $request) {

        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'sekolah' => 'sometimes|string|max:255',
            'nis' => 'sometimes|string|max:255',
            'keahlian' => 'sometimes|string|max:255',
            'penempatan' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'sikap' => 'required|string|max:255',
            'name_perusahaan' => 'sometimes',
            'alamat' => 'sometimes'
        ]);


        $magang = Magang::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'sekolah' => $request->sekolah,
            'nis' => $request->nis,
            'keahlian' => $request->keahlian,
            'penempatan' => $request->penempatan,
            'tanggal' => $request->tanggal,
            'sikap' => $request->sikap,
            'name_perusahaan' => $request->name_perusahaan,
            'alamat' => $request->alamat
        ]);


        $magang = Magang::with(['user'])->find($magang->id);

        try {
            $magang->save();
            return ResponseFormmater::success(
                $magang,
                'Data Magang berhasil dibuat'
            );
        }

        catch (Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Data Magang gagal di buat',
                505
            );
        }
    }

    public function getMagang(Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $name = $request->input('name');

        if($id) {
            $magang = Magang::with(['user'])->find($id);

            if($magang) {
                return ResponseFormmater::success(
                    $magang,
                    'Data magang berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data magang tidak ada',
                    505
                );
            }
        }

        $magang = Magang::with(['user']);

        if($name) {
            $magang->where('name', 'LIKE', '%' . $name . '%');
        }

        return ResponseFormmater::success(
            $magang->paginate($limit),
            'Data List magang berhasil diambil'
        );
    }

    public function updateMagang(Request $request , $id) {
        $magang = Magang::with(['user'])->findOrFail($id);
        $magang->update($request->all());

        return ResponseFormmater::success(
            $magang,
            'Data magang berhasil di update'
        );
    }


    public function deleteMagang(Request $request , $id) {
        $magang = Magang::with(['user'])->findOrFail($id);
        $magang->delete($request->all());

        return ResponseFormmater::success(
            $magang,
            'Data magang berhasil di delete'
        );
    }
}
