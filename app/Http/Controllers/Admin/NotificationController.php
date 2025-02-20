<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate();
        return view('admin.notification.index', compact('notifications'));
    }

    /**
     * @param  int  $id  Notification ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect()->route('notifications.index')
            ->with('success', 'Notification mark as read successfully.');
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->delete();
        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }
}
