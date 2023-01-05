<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function createCategory (Request $request) {
        $request->validate([
            'name_category' => 'required|string|max:255',
            'photo_category' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $category = Category::create([
            'name_category' => $request->name_category,
            'photo_category' => $request->photo_category,
        ]);


        if($request->file('photo_category')->isValid()) {
            $nameCategory = $request->file('photo_category');
            $extensions = $nameCategory->getClientOriginalExtension();
            $categoryUpload = "category/" .\date('YmdHis').".".$extensions;
            $categoryPath = \env('UPLOAD_PATH'). "/category";
            $request->file('photo_category')->move($categoryPath, $categoryUpload);
            $category['photo_category'] = $categoryUpload;
        }

        try {
            $category->save();
            return ResponseFormmater::success(
                $category,
                'Data Category Berhasil diambil'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error,
                'Data Supplier Gagal diambil',
                404
            );
        }
    }

    public function getCategory (Request $request) {
        $id = $request->input('id');
        $name_category = $request->input('name_category');

        if($id) {
            $category = Category::find($id);

            if($category) {
                return ResponseFormmater::success(
                    $category,
                    'Data Category Berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Data Category tidak ada',
                    404
                );
            }
        }

        $category = Category::query();

        if($name_category) {
            $category->where('name_category', 'like', '%' . $name_category . '%');
        }

        return ResponseFormmater::success(
            $category->get(),
            'Data List Category Berhasil diambil'
        );
    }

    public function updateCategory(Request $request, $id) {
        $category = Category::findOrFail($id);
        $data = $request->all();

        if($request->hasFile('photo_category')) {
            if($request->file('photo_category')->isValid()) {
                Storage::disk('upload')->delete($category->photo_category);
                $nameCategory = $request->file('photo_category');
                $extensions = $nameCategory->getClientOriginalExtension;
                $categoryUpload = "category/" .\date('YmdHis').".".$extensions;
                $categoryPath = \env('UPLOAD_PATH'). "/category";
                $request->file('photo_category')->move($categoryPath, $categoryUpload);
                $data['photo_category'] = $categoryUpload;
            }
        }

        $category->update($data);
        return ResponseFormmater::success(
            $category,
            'Data Category Berhasil di update'
        );
    }

    public function deleteCategory(Request $request, $id) {
        $category = Category::findOrFail($id);
        Storage::disk('upload')->delete($category->photo_category);

        $category->delete();
        return ResponseFormmater::success(
            $category,
            'Data Category Berhasil di delete'
        );
    }
}
