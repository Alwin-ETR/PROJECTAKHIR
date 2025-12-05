<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SuspensionUnlocked;
use App\Models\Suspension;
use Illuminate\Support\Facades\Mail;

class SuspensionController extends Controller
{
    public function index()
    {
        $suspensions = Suspension::with('user')
            ->orderBy('suspended_until', 'desc')
            ->paginate(15);

        return view('admin.suspensions.index', compact('suspensions'));
    }

    public function unlock(Suspension $suspension)
    {
        if ($suspension->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Suspend sudah tidak aktif'
            ], 400);
        }

        $suspension->update(['status' => 'expired']);

        // Send email notification
        Mail::to($suspension->user->email)
            ->send(new SuspensionUnlocked($suspension));

        return response()->json([
            'success' => true,
            'message' => 'Suspend user berhasil di-unlock. Email notifikasi telah dikirim.'
        ]);
    }
}
