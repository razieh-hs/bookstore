<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnRequest;

class AdminReturnController extends Controller
{
    public function index()
    {
        $returns = ReturnRequest::with(['user', 'order.items'])->latest()->get();
        return view('admin.returns', compact('returns'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $return = ReturnRequest::findOrFail($id);
        $return->status = $request->status;
        $return->admin_note = $request->admin_note;

        if (in_array($request->status, ['approved', 'rejected'])) {
            $return->resolved_at = now();
        }

        $return->save();

        return back()->with('success', 'وضعیت درخواست مرجوعی به‌روزرسانی شد.');
    }
}