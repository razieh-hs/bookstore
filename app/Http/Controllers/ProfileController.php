<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Message;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with('items')->latest()->take(5)->get();
        $myComments = Comment::with('book')->where('user_id', $user->id)->latest()->take(3)->get();
        $commentsCount = Comment::where('user_id', $user->id)->count();
        $avgRating = Comment::where('user_id', $user->id)->avg('rating');
        $purchasedCount = Order::where('user_id', $user->id)
            ->where('status', 'approved')
            ->with('items')
            ->get()
            ->flatMap->items
            ->sum('quantity');
        $pendingReturns = \App\Models\ReturnRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $unreadReplies = Message::where('user_id', $user->id)
            ->where('status', 'replied')
            ->count();

        return view('profile.index', compact(
            'user', 'orders', 'myComments', 'commentsCount', 'avgRating',
            'purchasedCount', 'pendingReturns', 'unreadReplies'
        ));
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
        ]);

        $user->update($data);

        return redirect()->route('profile.index')
            ->with('success', 'پروفایل با موفقیت به‌روزرسانی شد ✨');
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items', 'returnRequest'])
            ->latest()
            ->get();

        return view('profile.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->with(['items', 'returnRequest'])
            ->findOrFail($id);

        return view('profile.order-detail', compact('order'));
    }

    public function comments()
    {
        $comments = Comment::with('book')->where('user_id', auth()->id())->latest()->get();
        return view('profile.comments', compact('comments'));
    }

    public function messages()
    {
        $messages = Message::where('user_id', auth()->id())->latest()->get();
        return view('profile.messages', compact('messages'));
    }
}