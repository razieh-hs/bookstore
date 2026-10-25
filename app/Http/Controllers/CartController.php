<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->get();

        return view('cart.index', [
            'books' => $books,
        ]);
    }

    public function checkout()
    {
        $books = Book::with('author')->get();

        return view('cart.checkout', [
            'books' => $books,
        ]);
    }

    public function pay(Request $request)
    {
        $cartJson = $request->input('cart_data');
        $cart = json_decode($cartJson, true);

        if (!$cart || count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است.');
        }

        $orderCode = 'KB-' . date('Ymd') . '-' . rand(1000, 9999);
        $totalPrice = 0;
        $booksData = Book::with('author')->get();
        $itemsToCreate = [];

        foreach ($cart as $item) {
            $book = $booksData->firstWhere('id', $item['id']);
            if ($book) {
                $qty = max(1, (int)$item['qty']);
                $totalPrice += $book->price * $qty;
                $itemsToCreate[] = [
                    'book_id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author->name ?? 'ناشناس',
                    'price' => $book->price,
                    'quantity' => $qty,
                    'cover' => $book->cover,
                ];
            }
        }

        if ($totalPrice === 0) {
            return redirect()->route('cart.index')->with('error', 'کتاب‌های سبد خرید یافت نشدند.');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_code' => $orderCode,
            'total_price' => $totalPrice + 45000,
            'status' => 'pending',
            'address' => $request->input('province') . '، ' . $request->input('city') . '، ' . $request->input('address'),
            'phone' => $request->input('phone', 'شماره ثبت نشده'),
        ]);

        foreach ($itemsToCreate as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }

        return redirect()->route('cart.success', ['code' => $orderCode]);
    }

    public function success($code)
    {
        return view('cart.success', ['code' => $code]);
    }
}