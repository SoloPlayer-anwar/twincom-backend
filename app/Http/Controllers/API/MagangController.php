<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Magang;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function pdfGenerateMagang(Request $request, $id) {
        $magang = Magang::with(['user'])->find($id);

        if($magang) {

            $title = 'public/pdf/magang/'.'magang-'.strtotime('now').'.pdf';

            $images = [
                'logo'=> base64_encode(file_get_contents(url('storage/assets/img/logo.png'))),
                'logo1'=> base64_encode(file_get_contents(url('storage/assets/img/logo1.png'))),
            ];
            // return view('pdf.perbaikan', compact(['title','perbaikan','images']));
            $pdf = Pdf::loadView('pdf.magang', compact(['title','magang','images']));

            Storage::put($title, $pdf->output());

            return ResponseFormmater::success([
                'pdf' => asset(Storage::url($title))
            ], 'Data magang berhasil dibuat');
        }

        return ResponseFormmater::error(
            null,
            'Data magang gagal diambil',
            404
        );
    }
}
