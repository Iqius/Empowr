<?php

// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
