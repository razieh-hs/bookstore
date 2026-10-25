<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => 'required|string',
            'body' => 'required|string|min:3|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'book_id' => $data['book_id'],
            'body' => $data['body'],
            'rating' => $data['rating'],
        ]);

        return back()->with('success', 'نظرت با موفقیت ثبت شد. ممنون! 🌟');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'نظر حذف شد.');
    }
}