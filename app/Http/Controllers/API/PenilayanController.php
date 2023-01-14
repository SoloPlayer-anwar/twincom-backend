<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Penilayan;
use Exception;
use Illuminate\Http\Request;

class PenilayanController extends Controller
{
    public function createPenilayan(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name_pemberi' => 'required',
            'jabatan_pemberi' => 'required',
            'cabang_pemberi' => 'required',
            'pemahaman_tugas' => 'required',
            'kecekatan_bekerja' => 'required',
            'kreatifitas_bekerja' => 'required',
            'pengambil_keputusan' => 'required',
            'kejujuran' => 'required',
            'kedewasaan_berpikir' => 'required',
            'tanggung_jawab' => 'required',
            'kemandirian' => 'required',
            'disiplin' => 'required',
            'antusias' => 'required',
            'komunikasi' => 'required',
            'kerjasama_team' => 'required',
            'empati' => 'required',
            'tanggal' => 'required'
        ]);


        $penilayan = Penilayan::create([
            'user_id' => $request->user_id,
            'name_pemberi' => $request->name_pemberi,
            'jabatan_pemberi' => $request->jabatan_pemberi,
            'cabang_pemberi' => $request->cabang_pemberi,
            'pemahaman_tugas' => $request->pemahaman_tugas,
            'kecekatan_bekerja' => $request->kecekatan_bekerja,
            'kreatifitas_bekerja' => $request->kreatifitas_bekerja,
            'pengambil_keputusan' => $request->pengambil_keputusan,
            'kejujuran' => $request->kejujuran,
            'kedewasaan_berpikir' => $request->kedewasaan_berpikir,
            'tanggung_jawab' => $request->tanggung_jawab,
            'kemandirian' => $request->kemandirian,
            'disiplin' => $request->disiplin,
            'antusias' => $request->required,
            'komunikasi' => $request->komunikasi,
            'kerjasama_team' => $request->kerjasama_team,
            'empati' => $request->empati,
            'tanggal' => $request->tanggal,
        ]);


        $penilayan = Penilayan::with(['user'])->find($penilayan->id);

        try {
            $penilayan->save();
            return ResponseFormmater::success(
                $penilayan,
                'Data Penilaian Berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Data Penilayan gagal ditambahkan',
                505
            );
        }

    }

    public function getPenilayan (Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $user_id = $request->input('user_id');


        if($id) {
            $penilayan = Penilayan::with(['user'])->find($id);

            if($penilayan) {
                return ResponseFormmater::success(
                    $penilayan,
                    'Data Penilayan berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Tidak ada data penilaian',
                    505
                );
            }
        }


        $penilayan = Penilayan::with(['user']);

        if($user_id) {
            $penilayan->where('user_id', $user_id);
        }

        return ResponseFormmater::success(
            $penilayan->paginate($limit),
            'Data List Penilayan berhasil diambil'
        );
    }

    public function updatePenilayan (Request $request, $id) {
        $penilayan = Penilayan::with(['user'])->findOrFail($id);
        $penilayan->update($request->all());

        return ResponseFormmater::success(
            $penilayan,
            'Data Penilayan Berhasil diupdate'
        );
    }

    public function deletePenilayan (Request $request, $id) {
        $penilayan = Penilayan::with(['user'])->findOrFail($id);
        $penilayan->delete($request->all());

        return ResponseFormmater::success(
            $penilayan,
            'Data Penilayan Berhasil delete'
        );
    }
}
