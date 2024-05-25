<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'adults' => 'required|integer|min:1',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $inputCheckin = $request->input('checkin');
        $inputCheckout = $request->input('checkout');

        $checkinDate = Carbon::parse($inputCheckin);
        $checkoutDate = Carbon::parse($inputCheckout);

        $checkin = $checkinDate->format('Y-m-d');
        $checkout = $checkoutDate->format('Y-m-d');

        // Calculate available room count
        $availableRoomCount = $this->calculateAvailableRoomCount($checkin, $checkout);


        $adults = $request->input('adults');
        $kids = $request->input('kids');

        $availableRooms = Room::with(['beds', 'facilities', 'images'])->orderBy('created_at', 'desc')->paginate(8);
        
        $commonOffer = Offer::where('status', 1)
                    ->whereDate('start_date', '<=', $checkin)
                    ->whereDate('end_date', '>=', $checkout)
                    ->first();

        $userId = Auth::id();
        $notifications = Notification::where('receiver_id', $userId)->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();

        return view('user.rooms.index', compact('availableRooms', 'checkin', 'checkout', 'adults', 'kids','commonOffer',
                    'availableRoomCount','notifications','notificationCount'));
    }

    private function calculateAvailableRoomCount($checkin, $checkout)
    {
        $availableRoomCount = [];
        
        $rooms = Room::all();

        foreach ($rooms as $room) {
            $roomId = $room->id;

            $totalRoomCount = $room->room_count;
            $bookedRoomCount = Booking::where('room_id', $roomId)
                ->where('status', '!=', 0) // Exclude cancelled bookings
                ->where('status', '!=', 3) // Exclude checked out bookings
                ->where(function ($query) use ($checkin, $checkout) {
                    $query->where(function ($q) use ($checkin, $checkout) {
                        $q->where('check_in', '<=', $checkin)
                            ->where('check_out', '>', $checkin);
                    })->orWhere(function ($q) use ($checkin, $checkout) {
                        $q->where('check_in', '<', $checkout)
                            ->where('check_out', '>=', $checkout);
                    });
                })
                ->sum('room_count');

            $availableRoomCount[$roomId] = $totalRoomCount - $bookedRoomCount;
        }

        return $availableRoomCount;
    }
  
}
