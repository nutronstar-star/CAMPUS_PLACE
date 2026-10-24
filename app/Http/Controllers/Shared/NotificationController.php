<?php
namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('read_status', false)
            ->update(['read_status' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->update(['read_status' => true]);
        
        return redirect()->back();
    }
}
