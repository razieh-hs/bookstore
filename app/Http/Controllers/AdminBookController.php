<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class AdminBookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('author');
        if ($g = $request->get('genre')) {
            $query->where('genre', $g);
        }
        $books = $query->get();
        $genres = BookController::genres();
        $currentGenre = $g;
        return view('admin.books', compact('books', 'genres', 'currentGenre'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|unique:books,id',
            'title' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'genre' => 'required|string',
            'price' => 'required|integer',
            'old' => 'nullable|integer',
            'rating' => 'required|numeric',
            'reviews' => 'required|integer',
            'year' => 'required|integer',
            'pages' => 'required|integer',
            'publisher' => 'required|string',
            'desc' => 'required|string',
            'cover' => 'nullable|string',
        ]);

        Book::create($data);
        return back()->with('success', 'کتاب با موفقیت اضافه شد.');
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'genre' => 'required|string',
            'price' => 'required|integer',
            'old' => 'nullable|integer',
            'rating' => 'required|numeric',
            'reviews' => 'required|integer',
            'year' => 'required|integer',
            'pages' => 'required|integer',
            'publisher' => 'required|string',
            'desc' => 'required|string',
            'cover' => 'nullable|string',
        ]);

        $book->update($data);
        return back()->with('success', 'کتاب با موفقیت ویرایش شد.');
    }

    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return back()->with('success', 'کتاب حذف شد.');
    }
}