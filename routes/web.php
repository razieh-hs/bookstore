<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminAuthorController;
use App\Http\Controllers\AdminReturnController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\SearchController;

Route::get('/', [BookController::class, 'home'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('authors.show');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/support', [SupportController::class, 'index'])->name('support.index');
Route::post('/support', [SupportController::class, 'storeMessage'])->name('support.store');
Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations.index');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/pay', [CartController::class, 'pay'])->name('cart.pay');
    Route::get('/cart/success/{code}', [CartController::class, 'success'])->name('cart.success');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/orders/{id}', [ProfileController::class, 'orderDetail'])->name('profile.orders.detail');
    Route::get('/profile/returns', [ReturnRequestController::class, 'index'])->name('profile.returns');
    Route::get('/profile/comments', [ProfileController::class, 'comments'])->name('profile.comments');
    Route::get('/profile/messages', [ProfileController::class, 'messages'])->name('profile.messages');

    Route::get('/returns/create/{orderId}', [ReturnRequestController::class, 'create'])->name('returns.create');
    Route::post('/returns', [ReturnRequestController::class, 'store'])->name('returns.store');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/books', [AdminBookController::class, 'index'])->name('books');
    Route::post('/books', [AdminBookController::class, 'store'])->name('books.store');
    Route::put('/books/{id}', [AdminBookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [AdminBookController::class, 'destroy'])->name('books.destroy');

    Route::get('/authors', [AdminAuthorController::class, 'index'])->name('authors');
    Route::post('/authors', [AdminAuthorController::class, 'store'])->name('authors.store');
    Route::put('/authors/{id}', [AdminAuthorController::class, 'update'])->name('authors.update');
    Route::delete('/authors/{id}', [AdminAuthorController::class, 'destroy'])->name('authors.destroy');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/users/{id}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggleAdmin');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    Route::get('/returns', [AdminReturnController::class, 'index'])->name('returns');
    Route::post('/returns/{id}/status', [AdminReturnController::class, 'updateStatus'])->name('returns.status');

    Route::get('/comments', [AdminController::class, 'comments'])->name('comments');
    Route::delete('/comments/{id}', [AdminController::class, 'destroyComment'])->name('comments.destroy');

    Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
    Route::post('/messages/{id}/reply', [AdminController::class, 'replyMessage'])->name('messages.reply');
    Route::delete('/messages/{id}', [AdminController::class, 'destroyMessage'])->name('messages.destroy');
});