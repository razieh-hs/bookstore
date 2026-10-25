<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller{
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    public function show($id)
    {
        $author = Author::findOrFail($id);
        $books = $author->books;
        return view('authors.show', compact('author', 'books'));
    }
}