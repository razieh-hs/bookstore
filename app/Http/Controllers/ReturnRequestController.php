<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Auth;

class ReturnRequestController extends Controller
{
    public function index()
    {
        $returns = ReturnRequest::with(['order.items'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('profile.returns', compact('returns'));
    }

    public function create($orderId)
    {
        $order = Order::where('user_id', Auth::id())->with('items')->findOrFail($orderId);

        if ($order->status !== 'approved') {
            return redirect()->route('profile.orders')
                ->with('error', 'فقط سفارش‌های تاییدشده قابل مرجوع هستند.');
        }

        if ($order->returnRequest) {
            return redirect()->route('profile.orders')
                ->with('error', 'برای این سفارش قبلاً درخواست مرجوعی ثبت شده.');
        }

        return view('returns.create', compact('order'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'reason' => 'required|string|min:10|max:1000',
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($data['order_id']);

        if ($order->status !== 'approved') {
            return back()->with('error', 'فقط سفارش‌های تاییدشده قابل مرجوع هستند.');
        }

        if ($order->returnRequest) {
            return back()->with('error', 'برای این سفارش قبلاً درخواست مرجوعی ثبت شده.');
        }

        ReturnRequest::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'reason' => $data['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('profile.orders')
            ->with('success', 'درخواست مرجوعی شما ثبت شد و در انتظار بررسی است.');
    }
}