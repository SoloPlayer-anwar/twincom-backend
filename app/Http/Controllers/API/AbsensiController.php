<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function createAbsensi(Request $request) {

        $validator = Validator::make($request->all(),[
            'user_id' => 'sometimes|exists:users,id',
            'pengaturan_id' => 'sometimes|exists:pengaturans,id',
            'waktu_id' => 'sometimes|exists:waktus,id',
            'keterangan_id' => 'sometimes|exists:keterangans,id',
            'tanggal' => 'required',
            'status' => 'required',
        ]);


        if($validator->fails()){
            return ResponseFormmater::error(
                null,
                $validator->errors(),
                500
            );
        }

        $cek = Absensi::where('waktu_id',$request->waktu_id)
        ->where('user_id',$request->user_id)
        ->whereDate('created_at',date('Y-m-d'));

        if($cek->first()){
            return ResponseFormmater::error(
                null,
                'User telah absen sebelumnya',
                500
            );
        }


        $absensi = Absensi::create([
            'user_id' => $request->user_id,
            'pengaturan_id' => $request->pengaturan_id,
            'waktu_id' => $request->waktu_id,
            'keterangan_id' => $request->keterangan_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'shift' => $request->shift,
            'time' => $request->time,
        ]);

        $absensi = Absensi::with(['user', 'pengaturan', 'waktu', 'keterangan'])->find($absensi->id);


        try {

            $absensi->save();
            return ResponseFormmater::success(
                $absensi,
                'Data Absensi Berhasil dibuat'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                null,
                $error->getMessage(),
                404
            );
        }
    }

    public function getAbsensi (Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $user_id = $request->input('user_id');
        $pengaturan_id = $request->input('pengaturan_id');
        $waktu_id = $request->input('waktu_id');
        $keterangan_id = $request->input('keterangan_id');
        $tanggal = $request->input('tanggal');
        $status = $request->input('status');
        $shift = $request->input('shift');

        if($id) {
            $absensi = Absensi::with(['user', 'pengaturan', 'waktu' , 'keterangan'])->find($id);

            if($absensi) {
                return ResponseFormmater::success(
                    $absensi,
                    'Data Absensi Berhasil di ambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data absensi tidak ada',
                    404
                );
            }
        }

        $absensi = Absensi::with(['user', 'pengaturan', 'waktu' , 'keterangan']);

        if($user_id) {
            $absensi->where('user_id', $user_id);
        }

        if($pengaturan_id) {
            $absensi->where('pengaturan_id', $pengaturan_id);
        }

        if($waktu_id) {
            $absensi->where('waktu_id', $waktu_id);
        }

        if($keterangan_id) {
            $absensi->where('keterangan_id', $keterangan_id);
        }

        if($tanggal) {
            $absensi->where('tanggal', 'like', '%' . $tanggal . '%');
        }

        if($shift) {
            $absensi->where('shift', 'like', '%' . $shift . '%');
        }

        if($status) {
            $absensi->where('status', 'like', '%' .$status . '%');
        }

        return ResponseFormmater::success(
            $absensi->paginate($limit),
            'Data List Absensi Berhasil diambil'
        );
    }

    public function getAbsensiReport (Request $request) {
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $pengaturan_id = $request->input('pengaturan_id');
        $waktu_id = $request->input('waktu_id');
        $keterangan_id = $request->input('keterangan_id');
        $tanggal = $request->input('tanggal');
        $status = $request->input('status');
        $shift = $request->input('shift');

        if($id) {
            $absensi = Absensi::with(['user', 'pengaturan', 'waktu' , 'keterangan'])->find($id);

            if($absensi) {
                return ResponseFormmater::success(
                    $absensi,
                    'Data Absensi Berhasil di ambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data absensi tidak ada',
                    404
                );
            }
        }

        $absensi = Absensi::with(['user', 'pengaturan', 'waktu' , 'keterangan']);

        if($user_id) {
            $absensi->where('user_id', $user_id);
        }

        if($pengaturan_id) {
            $absensi->where('pengaturan_id', $pengaturan_id);
        }

        if($waktu_id) {
            $absensi->where('waktu_id', $waktu_id);
        }

        if($keterangan_id) {
            $absensi->where('keterangan_id', $keterangan_id);
        }

        if($tanggal) {
            $absensi->where('tanggal', 'like', '%' . $tanggal . '%');
        }

        if($shift) {
            $absensi->where('shift', 'like', '%' . $shift . '%');
        }

        if($status) {
            $absensi->where('status', 'like', '%' .$status . '%');
        }

        return ResponseFormmater::success(
            $absensi->get(),
            'Data List Absensi Berhasil diambil'
        );
    }


    public function deleteAbsensi (Request $request, $id) {
        $absensi = Absensi::with(['user', 'pengaturan', 'waktu'])->findOrFail($id);
        $data = $request->all();

        $absensi->update($data);
        return ResponseFormmater::success(
            $absensi,
            'Data Absensi Berhasil di Delete'
        );
    }
}
