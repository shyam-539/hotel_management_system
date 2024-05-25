<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Booking::with(['room', 'user'])->orderBy('created_at', 'desc');

        if ($request->has('searchDate')) {
            $searchDate = Carbon::parse($request->input('searchDate'))->format('Y-m-d');

            $query->whereDate('check_in', $searchDate);
        }

        $bookings = $query->get();

        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
            ->where('status', 1)
            ->count();

        return view('admin.bookings.index', compact('bookings', 'notifications', 'notificationCount'));

    }


    /**
     * Display the specified resource.
     */
    public function checkIn($id)
    {
       $booking = Booking::find($id);
       if ($booking) {
           $booking->status = 2;
           $booking->save();
   
           return redirect()->back()->with('success', 'Check In.');
       } 
    }
    public function checkOut($id)
    {
       $booking = Booking::find($id);

       if ($booking) {
           $booking->status = 3;
           $booking->save();

            $userId = $booking->user_id;
            $adminId = auth()->user()->id; 
            $message = "You has been checked out. Thank you for using our service. Please Review here";

            Notification::create([
                'sender_id' => $adminId,
                'receiver_id' => $userId,
                'booking_id' => $booking->id,
                'message' => $message,
                'status' => '1', //unseen
            ]);
           
           return redirect()->back()->with('success', 'Check Out.');
       } 
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->status = 0;
            $booking->save();
    
            return redirect()->back()->with('success', 'Booking canceled successfully.');
        } else {
            return redirect()->back()->with('error', 'Booking not found.');
        }
    }
    
}
