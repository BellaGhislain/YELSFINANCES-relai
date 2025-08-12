<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Session;
use App\Models\Formation;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    public function index()
    {
        $orders = Order::with('orderDetails.formation', 'orderDetails.session')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'company' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.formation_id' => 'required|integer|exists:formations,id',
            'items.*.session_id' => 'required|integer|exists:training_sessions,id',
        ]);

        $total_price = 0;
        foreach ($validated['items'] as $item) {
            $session = Session::findOrFail($item['session_id']);
            $total_price += $session->price;
        }

        $order = Order::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'],
            'country' => $validated['Cameroun'],
            'total_price' => $total_price,
            'status' => 'pending',
        ]);

        foreach ($validated['items'] as $item) {
            $session = Session::findOrFail($item['session_id']);
            OrderDetail::create([
                'order_id' => $order->id,
                'formation_id' => $item['formation_id'],
                'session_id' => $item['session_id'],
                'price' => $session->price,
            ]);
        }

        return response()->json(['order_id' => $order->id], 201);
    }

    public function confirmation($order_id)
    {
        $order = Order::with('orderDetails.session.formation')->findOrFail($order_id);
        return view('client.order_confirmation', compact('order'));
    }
}
