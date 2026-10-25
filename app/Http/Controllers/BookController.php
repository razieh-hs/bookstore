<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    public static function genres(): array
    {
        return ['رمان','شعر','داستان کوتاه','روانشناسی','توسعه فردی','تاریخ','فلسفه','علمی-تخیلی','کودک و نوجوان','هنر','سفر','آشپزی'];
    }

    public function home()
    {
        $bestSellers = Book::with('author')->orderBy('reviews', 'desc')->take(10)->get();
        $newBooks = Book::with('author')->orderBy('year', 'desc')->take(10)->get();
        $topAuthors = Author::orderBy('works', 'desc')->take(8)->get();
        $shelfBooks = Book::with('author')->take(12)->get();
        $booksCount = Book::count();
        $authorsCount = Author::count();

        return view('home', compact('bestSellers', 'newBooks', 'topAuthors', 'shelfBooks', 'booksCount', 'authorsCount'));
    }

    public function index(Request $request)
    {
        $query = Book::with('author');

        if ($g = $request->get('genre')) {
            $query->where('genre', $g);
        }

        if ($q = trim($request->get('q', ''))) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('desc', 'like', "%{$q}%")
                    ->orWhere('desc_long', 'like', "%{$q}%")
                    ->orWhere('publisher', 'like', "%{$q}%")
                    ->orWhereHas('author', fn($a) => $a->where('name', 'like', "%{$q}%"));
            });
        }

        $books = $query->get();

        return view('books.index', [
            'books' => $books,
            'genres' => self::genres(),
        ]);
    }

    public function show($id)
    {
        $book = Book::with('author')->findOrFail($id);

        $similar = Book::with('author')
            ->where('genre', $book->genre)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        $comments = \App\Models\Comment::where('book_id', $id)->with('user')->latest()->get();
        $avgRating = $comments->avg('rating') ?: $book->rating;
        $commentCount = $comments->count();

        return view('books.show', compact('book', 'similar', 'comments', 'avgRating', 'commentCount'));
    }
}