<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $books = collect();
        $authors = collect();

        if ($q !== '') {
            $books = Book::with('author')
                ->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('desc', 'like', "%{$q}%")
                        ->orWhere('desc_long', 'like', "%{$q}%")
                        ->orWhere('genre', 'like', "%{$q}%")
                        ->orWhere('publisher', 'like', "%{$q}%")
                        ->orWhereHas('author', fn($a) => $a->where('name', 'like', "%{$q}%"));
                })
                ->orderBy('reviews', 'desc')
                ->get();

            $authors = Author::where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('full_name', 'like', "%{$q}%")
                    ->orWhere('pen_name', 'like', "%{$q}%")
                    ->orWhere('role', 'like', "%{$q}%")
                    ->orWhere('nationality', 'like', "%{$q}%")
                    ->orWhere('born_city', 'like', "%{$q}%")
                    ->orWhere('died_city', 'like', "%{$q}%");
            })
            ->orderBy('works', 'desc')
            ->get();
        }

return view('search', compact('q', 'books', 'authors'));
    }
}