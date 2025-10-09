<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController
{
    public function index()
    {
        $data = User::all();
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
        $data = new User;

        $rules = [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'in:admin,staff,guest'
        ];
        $messages = [
            'name.required' => 'Nama pengguna wajib diisi',
            'name.min' => 'Nama pengguna minimal 3 karakter',

            'email.required' => 'Email pengguna wajib diisi',
            'email.email' => 'Email pengguna tidak valid',
            'email.unique' => 'Email pengguna telah terdaftar, gunakan yang lain',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',

            'role.in' => 'Role invalid',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $validator->errors()
            ], 500);
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->role = $request->role;
        
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
        $data = User::find($id);
        if($data){ // null handling
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

    public function update(Request $request, $id)
    {
        $data = User::find($id);
        if(empty($data)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak tersedia'
            ]);
        }

        $rules = [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|string|in:admin,staff,guest'
        ];
        $messages = [
            'name.required' => 'Nama wajib diisi',
            'name.min' => 'Nama minimal 3 karakter',

            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email telah terdaftar, gunakan yang lain',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $validator->errors()
            ], 500);
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->role = $request->role;
        
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
        $data = User::find($id);
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
