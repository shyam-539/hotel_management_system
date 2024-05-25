<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RatingRequest;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
   
    public function create($id)
    {

        $booking_id = $id;
        $userId = Auth::id();
        $notifications = Notification::where('receiver_id', $userId)->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();

        return view('user.rating.create',compact('booking_id','notifications','notificationCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RatingRequest $request)
    {

        $rating = new Rating();
        $rating->booking_id = $request->booking_id;
        $rating->comments = $request->comments;
        $rating->rating = $request->rating;
        $rating->save();

        return redirect()->route('user.booking.show')->with('success', 'Review submitted successfully!');
    
    }

    /**
     * Display the specified resource.
     */
    public function edit( $id)
    {
        $booking = Booking::findOrFail($id);
        $booking_id = $id;
        $rating = Rating::where('booking_id', $id)->first(); 

        $userId = Auth::id();

        $notifications = Notification::where('receiver_id', $userId)->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();
        return view('user.rating.edit',compact('rating','booking_id','notifications','notificationCount'));
    }

    /** Update the specified resource in storage.
     */
    public function update(RatingRequest $request,  $id)
    {
        $rating = Rating::find($id);
        $rating->update([

            'booking_id' => $request['booking_id'],
            'comments' => $request['comments'],
            'rating' => $request['rating'],
        ]);

        return redirect()->route('user.booking.show')->with('success', 'Review submitted successfully!');

    }

}
