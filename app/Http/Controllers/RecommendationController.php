<?php

namespace App\Http\Controllers;

use App\Models\Book;

class RecommendationController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->latest()->get();

        return view('recommendations', ['books' => $books]);
    }
}