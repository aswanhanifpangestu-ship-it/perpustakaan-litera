<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /** Tandai satu notifikasi sebagai sudah dibaca */
    public function markRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        $url = $notification->url ?? route('dashboard');
        return redirect($url);
    }

    /** Tandai semua notifikasi sebagai sudah dibaca */
    public function markAllRead()
    {
        $role = Auth::user()->role;

        Notification::forRole($role)->unread()->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    /** Hapus satu notifikasi */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notifikasi dihapus.');
    }

    /** Halaman daftar semua notifikasi */
    public function index()
    {
        $role          = Auth::user()->role;
        $notifications = Notification::forRole($role)
                            ->with('actor')
                            ->latest()
                            ->paginate(20);

        // Tandai semua sebagai dibaca saat halaman dibuka
        Notification::forRole($role)->unread()->update(['is_read' => true]);

        return view('notifications.index', compact('notifications'));
    }
}
