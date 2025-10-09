<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OrderController
{
    protected function generateUniqueTrackingNumber(int $length = 10): string
    {
        do {
            $candidate = strtoupper(Str::random($length));
        } while (Order::where('tracking_number', $candidate)->exists());

        return $candidate;
    }

    public function index()
    {
        $data = Order::all();
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
        $data = new Order;

        $rules = [
            'user_id' => 'required|exists:users,id_user',
            'total' => 'required|numeric|min:0',
            'payment' => 'required|in:cod,bri,bca',
            'shipping_address' => 'required|string|min:3',
            'status' => 'required|in:paid,pending,complete,cancelled',
        ];
        $messages = [
            'user_id.required' => 'User tidak terdaftar.',
            'user_id.exists' => 'User tidak ditemukan.',

            'total.required' => 'Harga wajib diisi.',
            'total.numeric' => 'Harga harus berupa angka.',
            'total.min' => 'Harga tidak boleh kurang dari 0.',

            'payment.required' => 'Payment wajib dipilih.',
            'payment.in' => 'Payment yang dipilih tidak ditemukan.',
            
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min' => 'Alamat pengiriman minimal 3 karakter.',
            'shipping_address.max' => 'Alamat pengiriman maksimal 100 karakter.',

            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status invalid.',
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
        $data->total = $request->total;
        $data->payment = $request->payment;
        $data->shipping_address = $request->shipping_address;
        $data->tracking_number = $this->generateUniqueTrackingNumber(16);
        $data->status = $request->status;
        
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
        $data = Order::find($id);
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
        $data = Order::find($id);
        if(empty($data)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak tersedia'
            ]);
        }

        $rules = [
            'user_id' => 'required|exists:users,id_user',
            'total' => 'required|numeric|min:0',
            'payment' => 'required|in:cod,bri,bca',
            'shipping_address' => 'required|string|min:3',
            'status' => 'required|in:paid,pending,complete,cancelled',
        ];
        $messages = [
            'user_id.required' => 'User tidak terdaftar.',
            'user_id.exists' => 'User tidak ditemukan.',

            'total.required' => 'Harga wajib diisi.',
            'total.numeric' => 'Harga harus berupa angka.',
            'total.min' => 'Harga tidak boleh kurang dari 0.',

            'payment.required' => 'Payment wajib dipilih.',
            'payment.in' => 'Payment yang dipilih tidak ditemukan.',
            
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min' => 'Alamat pengiriman minimal 3 karakter.',
            'shipping_address.max' => 'Alamat pengiriman maksimal 100 karakter.',

            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status invalid.',
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
        $data->total = $request->total;
        $data->payment = $request->payment;
        $data->shipping_address = $request->shipping_address;
        $data->tracking_number = $this->generateUniqueTrackingNumber(16);
        $data->status = $request->status;
        
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

    public function destroy($id)
    {
        $data = Order::find($id);
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

    public function track($track_number){
        $data = Order::with(['items.product', 'items.variant'])
                ->where('tracking_number', $track_number)
                ->first();

        if($data){ 
            return response()->json([
                'status' => true,
                'message' => 'Pesanan ditemukan',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan tidak ditemukan'
            ]);
        }
    }
}
