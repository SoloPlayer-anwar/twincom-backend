<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Prosuder;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProsuderController extends Controller
{
    public function createProsuder(Request $request) {

        $request->validate([
            'name_bm' => 'required|string|max:255',
            'jabatan_bm' => 'required|string|max:255',
            'cabang_bm' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'options_id' => 'required|exists:options,id',
            'tdm' => 'sometimes',
            'mengetahui' => 'sometimes'
        ]);

        $prosuder = Prosuder::create([
            'name_bm' => $request->name_bm,
            'jabatan_bm' => $request->jabatan_bm,
            'cabang_bm' => $request->cabang_bm,
            'user_id' => $request->user_id,
            'options_id' => $request->options_id,
            'tdm' => $request->tdm,
            'mengetahui' => $request->mengetahui
        ]);

        $prosuder = Prosuder::with(['options', 'user'])->find($prosuder->id);

        try {
            $prosuder->save();
            return ResponseFormmater::success(
                $prosuder,
                'Data Prosuder berhasil dibuat'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Data Prosuder gagal dibuat',
                500
            );
        }
    }

    public function getProsuder (Request $request) {
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $options_id = $request->input('options_id');
        $name_bm = $request->input('name_bm');
        $mengetahui = $request->input('mengetahui');

        if($id) {
            $prosuder = Prosuder::with(['options', 'user'])->find($id);

            if($prosuder) {
                return ResponseFormmater::success(
                    $prosuder,
                    'Data Prosuder berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data Prosuder gagal diambil',
                    500
                );
            }
        }

        $prosuder = Prosuder::with(['options', 'user']);

        if($user_id) {
            $prosuder->where('user_id', $user_id);
        }

        if($options_id) {
            $prosuder->where('options_id', $options_id);
        }

        if($name_bm) {
            $prosuder->where('name_bm', 'like', '%' . $name_bm . '%');
        }

        if($mengetahui) {
            $prosuder->where('mengetahui', 'like', '%' . $mengetahui . '%');
        }

        return ResponseFormmater::success(
            $prosuder->get(),
            'Data List Prosuder berhasil diambil'
        );
    }

    public function updateProsuder (Request $request , $id) {
        $prosuder = Prosuder::with(['options', 'user'])->findOrFail($id);
        $prosuder->update($request->all());

        return ResponseFormmater::success(
            $prosuder,
            'Data Prosuder Berhasil di update'
        );
    }

    public function deleteProsuder (Request $request , $id) {
        $prosuder = Prosuder::with(['options', 'user'])->findOrFail($id);
        $prosuder->delete($request->all());

        return ResponseFormmater::success(
            $prosuder,
            'Data Prosuder Berhasil di delete'
        );
    }

    public function pdfGenerate(Request $request , $id) {
        $prosuder = Prosuder::with(['options', 'user'])->find($id);

        if($prosuder) {
            $title = 'public/pdf/perbaikan/'.'perbaikan-'.strtotime('now').'.pdf';

            $images = [
                'logo1' => \base64_encode(file_get_contents(\url('storage/assets/img/logo1.png'))),
                'logo2' => \base64_encode(file_get_contents(\url('storage/assets/img/logo2.png'))),
            ];

            $pdf = Pdf::loadView('pdf.prosuder', compact(['title','prosuder','images']));

            Storage::put($title, $pdf->output());

            return ResponseFormmater::success([
                'pdf' => \asset(Storage::url($title))
            ], 'Data Prosuder berhasil dibuat');
        }

        return ResponseFormmater::error(
            null,
            'Data Keluhan gagal diambil',
            404
        );
    }
}
