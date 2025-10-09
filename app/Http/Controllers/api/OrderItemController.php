<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController
{
    public function index()
    {
        $data = OrderItem::all();
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
        $data = new OrderItem;

        $rules = [
            'order_id' => 'required|exists:orders,id_order',
            'product_id' => 'required|exists:products,id_product',
            'variant_id' => 'required|exists:product_variants,id_variant',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ];
        $messages = [
            'user_id.required' => 'User tidak terdaftar.',
            'product_id.exists' => 'User tidak ditemukan.',

            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk yang dipilih tidak ditemukan.',

            'variant_id.required' => 'Variasi wajib dipilih.',
            'variant_id.exists' => 'Variasi yang dipilih tidak ditemukan.',

            'qty.required' => 'Kuantiti produk wajib diisi.',
            'qty.integer' => 'Kuantiti produk harus berupa angka bulat.',
            'qty.min' => 'Kuantiti produk tidak valid',

            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',

            'subtotal.required' => 'Subtotal wajib diisi.',
            'subtotal.numeric' => 'Subtotal harus berupa angka.',
            'subtotal.min' => 'Subtotal tidak boleh kurang dari 0.',
        ];

        $variant = ProductVariant::where('id_variant', $request->variant_id)
                ->where('product_id', $request->product_id)
                ->first();

        if (!$variant) {
            return response()->json([
                'error' => 'Varian tidak tersedia.'
            ], 422);
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $validator->errors()
            ], 500);
        }

        $data->user_id = $request->user_id;
        $data->product_id = $request->product_id;
        $data->variant_id = $request->variant_id;
        $data->stock = $request->stock;
        
        try {
            $post = $data->save();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambahkan data',
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
        $data = OrderItem::find($id);
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
        $data = ProductVariant::find($id);
        if(empty($data)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak tersedia'
            ]);
        }

        $rules = [
            'user_id' => 'required|exists:users,id_user',
            'product_id' => 'required|exists:products,id_product',
            'variant_id' => 'required|exists:product_variants,id_variant',
            'stock' => 'required|integer|min:0',
        ];
        $messages = [
            'user_id.required' => 'User tidak terdaftar.',
            'product_id.exists' => 'User tidak ditemukan.',

            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk yang dipilih tidak ditemukan.',

            'variant_id.required' => 'Variasi wajib dipilih.',
            'variant_id.exists' => 'Variasi yang dipilih tidak ditemukan.',

            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak valid',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $validator->errors()
            ], 500);
        }

        $data->user_id = $request->user_id;
        $data->product_id = $request->product_id;
        $data->variant_id = $request->variant_id;
        $data->stock = $request->stock;
        
        try {
            $post = $data->save();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambahkan data',
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
        $data = OrderItem::find($id);
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
