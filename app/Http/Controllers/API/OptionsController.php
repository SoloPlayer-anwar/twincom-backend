<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Option;
use Exception;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function createOptions (Request $request) {

        $request->validate([
            'options' => 'required|string|max:255',
            'keterangan' => 'required'
        ]);

        $options = Option::create([
            'options' => $request->options,
            'keterangan' => $request->keterangan
        ]);

        try {
            $options->save();
            return  ResponseFormmater::success(
                $options,
                'Data Options Berhasil dibuat'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Data Options gagal dibuat',
                500
            );
        }
    }

    public function getOptions (Request $request) {
        $id = $request->input('id');

        if($id) {
            $options = Option::find($id);

            if($options) {
                return ResponseFormmater::success(
                    $options,
                    'Data Options Berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data Options tidak ada',
                    500
                );
            }
        }

        $option = Option::query();

        return ResponseFormmater::success(
            $option->get(),
            'Data List Options berhasil diambil'
        );
    }

    public function updateOptions (Request $request , $id) {
        $options = Option::findOrFail($id);

        $options->update($request->all());
        return ResponseFormmater::success(
            $options,
            'Data Options berhasil di update'
        );
    }

    public function deleteOptions (Request $request , $id) {
        $options = Option::findOrFail($id);

        $options->delete($request->all());
        return ResponseFormmater::success(
            $options,
            'Data Options berhasil di delete'
        );
    }
}
