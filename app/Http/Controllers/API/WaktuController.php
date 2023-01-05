<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Waktu;
use Exception;
use Illuminate\Http\Request;

class WaktuController extends Controller
{
    public function createWaktu(Request $request) {

        $request->validate([
            'status' => 'sometimes|string|max:255',
            'shift' => 'sometimes|string|max:255',
            'tanggal' => 'sometimes|string|max:255'
        ]);

        $waktu = Waktu::create([
            'status' => $request->status,
            'shift' => $request->shift,
            'tanggal' => $request->tanggal
        ]);

        try {
            $waktu->save();
            return ResponseFormmater::success(
                $waktu,
                'Data Waktu berhasil dibuat'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                null,
                'Data Waktu tidak ada',
                404
            );
        }
    }

    public function getWaktu (Request $request) {
        $id = $request->input('id');
        $status = $request->input('status');
        $shift = $request->input('shift');
        $tanggal = $request->input('tanggal');

        if($id) {
            $waktu = Waktu::find($id);

            if($waktu) {
                return ResponseFormmater::success(
                    $waktu,
                    'Data waktu berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data waktu gagal diambil',
                    404
                );
            }
        }

        $waktu = Waktu::query();

        if($status) {
            $waktu->where('status', 'like', '%' . $status . '%');
        }

        if($shift) {
            $waktu->where('shift', 'like', '%' . $shift . '%');
        }

        if($tanggal) {
            $waktu->where('tanggal', 'like', '%' . $tanggal . '%');
        }

        return ResponseFormmater::success(
            $waktu->get(),
            'Data list waktu berhasil diambil'
        );
    }
}
