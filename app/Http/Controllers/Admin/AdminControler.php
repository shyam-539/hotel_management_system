<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminControler extends Controller
{
    public function index() : View {
     
        $totalRoomCount = DB::table('rooms')->sum('room_count');

        $totalRoomCountBooked = DB::table('bookings')
            ->whereNotIn('status', [0, 3])
            ->sum('room_count');

        $availableRooms = $totalRoomCount - $totalRoomCountBooked ;

        $totalRoomCountBookToday = DB::table('bookings')
            ->whereNotIn('status', [0, 3])
            ->where('check_in','<=',date('Y-m-d'))
            ->where('check_out','>=',date('Y-m-d'))
            ->sum('room_count');

            //  dd($totalRoomCountBookToday);

        $availabeleRoomsToday =  $totalRoomCount - $totalRoomCountBookToday ;

        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();
        
        $bookings = Booking::with(['room', 'user'])->get();

        return view('admin.index',compact('totalRoomCount','totalRoomCountBooked','availableRooms','notifications',
            'notificationCount','bookings','availabeleRoomsToday'));
       }
}
