<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;

class NotificationController extends Controller
{
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $notification = Notification::find($id);

        if ($notification) {
            $notification->update(['status' => 0]);


            $booking = Booking::where('id', $notification->booking_id)->first();

        }
        return redirect()->route('admin.bookings.index');
    }
  
}
