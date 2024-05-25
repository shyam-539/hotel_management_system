<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;

class NotificationController extends Controller
{
  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->update(['status' => 0]);

            $booking = Booking::where('id', $notification->booking_id)->first();

            if ($booking) {
                if ($booking->status == 3) {
                    return redirect()->route('user.rating.create', ['id' => $notification->booking_id]);
                } elseif ($booking->status == 1) {
                    return redirect()->route('user.booking.show');
                }
            }

        }
        return redirect()->back();
    }

}
