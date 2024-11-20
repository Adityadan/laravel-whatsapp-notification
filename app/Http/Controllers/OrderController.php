<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderProcessed;
use Faker\Factory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi data yang diterima dari request
            // $validatedData = $request->validate([
            //     'name' => 'required|string|max:255',
            //     'amount' => 'required|integer|min:1000|max:9000',
            // ]);

            // Buat order baru menggunakan factory
            // $order = \App\Models\Order::factory()->create();
            $order = Order::factory()->create();
            // dd($order->toArray());
            // Kirim notifikasi ke user
            $request->user()->notify(new OrderProcessed($order));

            // Kembalikan response JSON dengan status berhasil
            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully!'
            ]);
        } catch (\Exception $e) {
            // Kembalikan response JSON dengan status gagal dan pesan error
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to place order: ' . $e->getMessage()
            ]);
        }
    }
}
