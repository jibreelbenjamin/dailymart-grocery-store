<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController
{
    public function index()
    {
        $data = Category::all();
        if($data->isEmpty()){
            return response()->json([
                'status' => null,
                'message' => 'Data kosong',
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $data = new Category;

        $rules = [
            'name' => 'required|string|min:3|max:255|unique:categories,slug|unique:categories,name',
        ];
        $messages = [
            'name.required' => 'Nama kategori wajib diisi',
            'name.min' => 'Nama kategori minimal 3 karakter',
            'name.unique' => 'Nama kategori telah digunakan, cari yang lain',
        ];
        $slug = Str::slug($request->name, '-');
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $validator->errors()
            ], 500);
        }

        $data->name = $request->name;
        $data->slug = $slug;
        
        try {
            $post = $data->save();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil memasukan data',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $data = Category::find($id);
        if($data){ 
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak tersedia'
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        $data = Category::find($id);
        if(empty($data)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak tersedia'
            ]);
        }

        $rules = [
            'name' => 'required|string|min:3|max:255|unique:categories,name',
        ];
        $messages = [
            'name.required' => 'Nama kategori wajib diisi',
            'name.min' => 'Nama kategori minimal 3 karakter',
            'name.unique' => 'Nama kategori telah digunakan, cari yang lain',
        ];
        $slug = Str::slug($request->name, '-');
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $validator->errors()
            ], 500);
        }

        $data->name = $request->name;
        $data->slug = $slug;
        
        try {
            $post = $data->save();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil update data',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $data = Category::find($id);
        if(empty($data)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak tersedia'
            ]);
        }
        
        try {
            $post = $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil hapus data',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
