<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AdminAuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('admin.authors', compact('authors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|unique:authors,id',
            'name' => 'required|string',
            'full_name' => 'nullable|string',
            'pen_name' => 'nullable|string',
            'handle' => 'nullable|string',
            'role' => 'required|string',
            'photo' => 'nullable|string',
            'short_bio' => 'nullable|string',
            'works' => 'required|integer',
            'born_date' => 'nullable|string',
            'born_city' => 'nullable|string',
            'born_country' => 'nullable|string',
            'died_date' => 'nullable|string',
            'died_city' => 'nullable|string',
            'died_country' => 'nullable|string',
            'burial_place' => 'nullable|string',
            'nationality' => 'nullable|string',
            'era' => 'nullable|string',
            'occupation' => 'nullable|string',
            'genre' => 'nullable|string',
            'education' => 'nullable|string',
            'spouse' => 'nullable|string',
        ]);

        $data['biography'] = $request->filled('biography')
            ? array_filter(array_map('trim', explode("\n", $request->input('biography'))))
            : ($request->short_bio ? [$request->short_bio] : []);
        $data['quotes'] = $request->filled('quotes')
            ? array_filter(array_map('trim', explode("\n", $request->input('quotes'))))
            : [];
        $data['awards'] = $request->filled('awards')
            ? array_filter(array_map('trim', explode("\n", $request->input('awards'))))
            : [];
        $data['facts'] = $request->filled('facts')
            ? array_filter(array_map('trim', explode("\n", $request->input('facts'))))
            : [];

        Author::create($data);
        return back()->with('success', 'نویسنده اضافه شد.');
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'full_name' => 'nullable|string',
            'pen_name' => 'nullable|string',
            'handle' => 'nullable|string',
            'role' => 'required|string',
            'photo' => 'nullable|string',
            'short_bio' => 'nullable|string',
            'works' => 'required|integer',
            'born_date' => 'nullable|string',
            'born_city' => 'nullable|string',
            'born_country' => 'nullable|string',
            'died_date' => 'nullable|string',
            'died_city' => 'nullable|string',
            'died_country' => 'nullable|string',
            'burial_place' => 'nullable|string',
            'nationality' => 'nullable|string',
            'era' => 'nullable|string',
            'occupation' => 'nullable|string',
            'genre' => 'nullable|string',
            'education' => 'nullable|string',
            'spouse' => 'nullable|string',
        ]);

        if ($request->filled('biography')) {
            $data['biography'] = array_filter(array_map('trim', explode("\n", $request->input('biography'))));
        }
        if ($request->filled('quotes')) {
            $data['quotes'] = array_filter(array_map('trim', explode("\n", $request->input('quotes'))));
        }
        if ($request->filled('awards')) {
            $data['awards'] = array_filter(array_map('trim', explode("\n", $request->input('awards'))));
        }
        if ($request->filled('facts')) {
            $data['facts'] = array_filter(array_map('trim', explode("\n", $request->input('facts'))));
        }

        $author->update($data);
        return back()->with('success', 'نویسنده ویرایش شد.');
    }

    public function destroy($id)
    {
        Author::findOrFail($id)->delete();
        return back()->with('success', 'نویسنده حذف شد.');
    }
}