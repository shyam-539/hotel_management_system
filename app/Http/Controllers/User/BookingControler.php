<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BookingRequest;
use App\Mail\ConfirmMail;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Loyality;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Rating;
use App\Models\Room;
use App\Models\User;
use App\Models\UserLoyality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingControler extends Controller
{

    public function Booking(Request $request,$id)
    {
       
            $room = Room::with(['beds', 'facilities', 'images'])->find($id);
            
            $totalPrice = $room->price; 
    
            $commonOffer = Offer::where('status', 1)
                                ->whereDate('start_date', '<=', now())
                                ->whereDate('end_date', '>=', now())
                                ->first();
            
            if ($commonOffer) {
                $totalPrice -= ($totalPrice * $commonOffer->discount_percentage / 100);
            }

            $taxPercentage = 10;
            $taxAmount = $totalPrice * ($taxPercentage / 100);
            $netAmount = $totalPrice + $taxAmount;

            $checkinDate = $request->input('checkin');
            $checkoutDate = $request->input('checkout');
            
            $checkin = Carbon::createFromFormat('Y-m-d', $checkinDate)->format('d-m-Y');
            $checkout = Carbon::createFromFormat('Y-m-d', $checkoutDate)->format('d-m-Y');

            $adultCount = $request->input('adults');
            $kidsCount = $request->input('kids');

            $numberOfNights = Carbon::parse($checkinDate)->diffInDays($checkoutDate);
            $availableRoomCount = $this->calculateAvailableRoomCount($room->id, $checkin, $checkout);

            $roomReviews = Rating::whereHas('booking', function ($query) use ($room) {
                $query->where('room_id', $room->id);
                })->get();
                
            $userId = auth()->user()->id;
            $notifications = Notification::where('receiver_id', $userId)->get();

            $notificationCount = Notification::where('receiver_id', $userId)
                ->where('status', 1)
                ->count();

            return view('user.rooms.booking', compact('room', 'totalPrice','commonOffer', 'taxPercentage', 'taxAmount',
             'netAmount', 'checkin', 'checkout','availableRoomCount','numberOfNights','adultCount','kidsCount','roomReviews',
             'notifications','notificationCount'));
    }


    private function calculateAvailableRoomCount($roomId, $checkin, $checkout)
    {
        $checkinFormatted = Carbon::createFromFormat('d-m-Y', $checkin)->format('Y-m-d');
        $checkoutFormatted = Carbon::createFromFormat('d-m-Y', $checkout)->format('Y-m-d');
    
        $totalRoomCount = Room::where('id', $roomId)->value('room_count');
    
        $bookedRoomCount = Booking::where('room_id', $roomId)
            ->where('status', '!=', 0) 
            ->where('status', '!=', 3)
            ->where(function ($query) use ($checkinFormatted, $checkoutFormatted) {
                $query->where(function ($q) use ($checkinFormatted, $checkoutFormatted) {
                    $q->where('check_in', '<=', $checkinFormatted)
                        ->where('check_out', '>', $checkinFormatted);
                })->orWhere(function ($q) use ($checkinFormatted, $checkoutFormatted) {
                    $q->where('check_in', '<', $checkoutFormatted)
                        ->where('check_out', '>=', $checkoutFormatted);
                });
            })
            ->sum('room_count');
    
        $availableRoomCount = $totalRoomCount - $bookedRoomCount;
    
        return $availableRoomCount;
    }
    
    
    public function store(BookingRequest $request, $id)
    {
        $user = auth()->user();
        $userId = $user->id; 
        $isFirstBooking = Booking::where('user_id', $userId)->count() == 0;

        // var_dump($isFirstBooking);
        //   var_dump($loyaltyPoints);
        //   dd($loyaltyPoints);

        $room = Room::findOrFail($id);

        if ($request->has('redeem_points')) {

            $redeemedPoints = $user->total_points;

            DB::table('users')->where('id', $userId)->update(['total_points' => 0]);

            DB::table('user_loyalities')->where('user_id', $userId)->update(['status' => 0]);
        
        } else {
            $redeemedPoints = 0; 
        }

        $totalPrice = $request->input('totalPrice');
        $taxAmount = $request->input('taxAmount');
        $netAmount = $totalPrice + $taxAmount;

        $booking = new Booking();
        $booking->user_id = $userId;
        $booking->room_id = $id;
        $booking->room_count = $request->input('roomCount');
        $booking->extra_bed = $request->input('extraBedCount');

        $booking->total_price = $totalPrice;
        $booking->tax_percentage = $request->input('taxPercentage');
        $booking->tax_amount = $taxAmount;
        $booking->net_amount = $netAmount;

        $booking->adult_count = $request->input('adultCount');
        $booking->child_count = $request->input('kidsCount');

        $checkIn = $request->input('checkin');
        $checkOut = $request->input('checkout');
        
        $checkInFormatted = Carbon::parse($checkIn)->format('Y-m-d');
        $checkOutFormatted = Carbon::parse($checkOut)->format('Y-m-d');
        
        $booking->check_in = $checkInFormatted;
        $booking->check_out = $checkOutFormatted;
        $booking->status = 1;
    
        $booking->save();


        if ($isFirstBooking===true) {
    
            $loyaltyTableId = 2;
            $userLoyalty = new UserLoyality(); 
            $userLoyalty->user_id = $userId;
            $userLoyalty->loyalty_id = $loyaltyTableId;
            $userLoyalty->save();
        
            $loyaltyPoints = Loyality::where('id', $loyaltyTableId)->value('points');

            DB::table('users')
            ->where('id', $userId)
            ->increment('total_points',$loyaltyPoints);
        }

        $loyaltyTableId = 3;
            $userLoyalty = new UserLoyality(); 
            $userLoyalty->user_id = $userId;
            $userLoyalty->loyalty_id = $loyaltyTableId;
            $userLoyalty->save();
        
            $loyaltyPoints = Loyality::where('id', $loyaltyTableId)->value('points');

            DB::table('users')
            ->where('id', $userId)
            ->increment('total_points',$loyaltyPoints);

        if($booking){

            $adminId = Admin::first()->id;

            Notification::create([
                'sender_id' => $adminId,
                'receiver_id' => $userId,
                'booking_id' => $booking->id,
                'message' => 'New booking has been made. Check your bookings for details.',
                'status' => '1',
            ]);
            Notification::create([
                'sender_id' => $userId,
                'receiver_id' => $adminId,
                'booking_id' => $booking->id,
                'message' => 'New booking has been made. Please review and confirm.',
                'status' => '1',
            ]);
        }

        Mail::to($request->user())->send(new ConfirmMail($booking));
    
        return redirect()->route('user.booking.show')->with('success', 'Room Booked Successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show()
    {

        $userId = Auth::id();

        $bookings = Booking::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(8);

        $notifications = Notification::where('receiver_id', $userId)->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();


        return view('user.bookings.show',compact('bookings','notifications','notificationCount'));
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
