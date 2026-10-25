<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Order;
use App\Models\Message;
use App\Models\Book;
use App\Models\Author;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
public function replyMessage(Request $request, $id)
{
    $request->validate([
        'admin_reply' => 'required|string|min:2',
    ]);

    $message = Message::findOrFail($id);
    $message->admin_reply = $request->admin_reply;
    $message->status = 'replied';
    $message->replied_at = now();
    $message->save();

    return back()->with('success', 'پاسخ با موفقیت ثبت شد.');
}
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalBooks' => Book::count(),
            'totalAuthors' => Author::count(),
            'totalUsers' => User::count(),
            'totalComments' => Comment::count(),
            'totalOrders' => Order::count(),
            'totalMessages' => Message::count(),
            'totalReturns' => ReturnRequest::where('status', 'pending')->count(),
            'recentComments' => Comment::with('user')->latest()->take(5)->get(),
            'recentUsers' => User::latest()->take(5)->get(),
        ]);
    }

    public function users(Request $request)
    {
        $query = User::withCount('comments')->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return view('admin.users', [
            'users' => $query->get(),
            'search' => $request->get('search'),
        ]);
    }

    public function editUser($id)
    {
        return view('admin.users-edit', [
            'user' => User::findOrFail($id),
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'is_admin' => 'nullable',
        ]);

        $data['is_admin'] = $request->has('is_admin');

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->get('password'));
        }

        $user->update($data);

        return redirect()->route('admin.users')
            ->with('success', 'کاربر با موفقیت به‌روزرسانی شد');
    }

    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'نمی‌تونی نقش خودت رو تغییر بدی!');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        return back()->with('success', $user->is_admin ? 'کاربر ادمین شد 👑' : 'دسترسی ادمین گرفته شد');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'نمی‌تونی حساب خودت رو حذف کنی!');
        }

        $user->delete();

        return back()->with('success', 'کاربر حذف شد');
    }

    public function orders()
    {
        $orders = Order::with(['user', 'items'])->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'وضعیت سفارش با موفقیت به‌روزرسانی شد.');
    }

    public function comments(Request $request)
    {
        $query = Comment::with('user')->latest();
        $books = Book::all()->keyBy('id');

        return view('admin.comments', [
            'comments' => $query->get(),
            'books' => $books,
        ]);
    }

    public function destroyComment($id)
    {
        Comment::findOrFail($id)->delete();
        return back()->with('success', 'نظر حذف شد');
    }

    public function messages()
    {
        $messages = Message::latest()->get();
        return view('admin.messages', compact('messages'));
    }

    public function destroyMessage($id)
    {
        Message::findOrFail($id)->delete();
        return back()->with('success', 'پیام حذف شد');
    }
}