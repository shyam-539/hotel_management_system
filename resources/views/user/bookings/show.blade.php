
@extends('user.layouts.master')
@section('content')
<link rel="stylesheet" href="{{url('assets/user/booking_view.css')}}">
<style>
.no-bookings-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh; /* Adjust as needed to center vertically on the screen */
}

.no-bookings-container img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px; /* Add spacing between image and text */
}

.no-bookings-container p {
    font-size: x-large;
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
<div class="w3-content" style="max-width:1532px;">
    @if (session('success'))
        <div class="alert alert-success" style="color: #ffffff; text-align: center; padding: 15px;  background: #f12600;">
            {{ session('success') }}
        </div>
    @endif
    @if ($bookings->isEmpty())
    <div class="no-bookings-container">
        <img src="{{ asset('storage/images/no-record.png') }}" alt="No bookings found">
        <p>No bookings found.</p>
    </div>
    @else

        <div class="room-list">
            @foreach ($bookings as $booking)
            <div class="room">
                <div class="room-image">
                    <img src="{{ asset('storage/uploads/'. $booking->room->images->first()->image_path) }}" alt="{{ $booking->room->type }}" >
                </div>
                    <div class="room-imagess">
                        <h3>{{ $booking->room->roomType->name }} {{ $booking->room->beds->first()->bed_type }} Room</h3>
                        <p>{{ $booking->room->beds->first()->bed_type }} bed</p>
                        <p>Persons: {{ $booking->adult_count }} Adults,  {{ $booking->child_count }} Child</p>
                        <p>Property size:  {{ $booking->room->room_size }}m<sup>2</sup></p>
                    </div>
                
            
                <div class="price-details">
                    <div class="dates" style="display: flex;justify-content: space-between;">
                        <h6 class="check-in-check-out">{{ $booking->check_in }}- {{ $booking->check_out }}</h6>
                        <h6>{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }}  Night(s)</h6>
                    
                    </div>
                    
                    <div class="room-count">
                        
                        <h6 id="roomCount"  name="roomCount" >Room Count: {{$booking->room_count}}</h6>
                    </div>
        
                    <div class="extra-bed">
                        <h6 id="extraBedCount" name="extraBedCount"  >Extra Bed: {{$booking->extra_bed}}</h6>

                    </div>
                    <h6 class="total-price" name="totalPrice">Total Price: $<span id="totalPrice" name="totalPrice">{{$booking->net_amount }}</span></h6>
                
                </div>
                <div class="room-details">
                    @if ($booking->status===1)
                        <button class="book-now-button" onclick="cancelBooking({{ $booking->id }})">Cancel</button> 
                        <h6 style="color: red;padding: 24px;font-size: larger;">{{\Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::now())}} Days to Go!</h6>
                
                    @elseif ($booking->status===2)
                        <h6 style="color: #1000cf;padding: 24px;font-size: larger;">Check In.</h6>
                    
                    @elseif ($booking->status===3)
                        @php
                            $reviewExists = App\Models\Rating::where('booking_id', $booking->id)->exists();
                        @endphp
                        @if ($reviewExists)
                            <a class="review-now-button " href="{{route('user.rating.edit', ['id' => $booking->id])}}" >Reviewed</a>
                        @else
                            <a class="review-now-button" href="{{ route('user.rating.create', ['id' => $booking->id]) }}">Review Here</a>
                        @endif
                    @else
                        <h6 style="color: red;padding: 24px;font-size: larger;">Cancelled!</h6>

                    @endif
                </div>
                </div>
                @endforeach
            </div>
        
        </div>
    @endif
</div>
<script>
    function cancelBooking(bookingId) {
        if (confirm("Are you sure you want to cancel this booking?")) {
            window.location.href = "{{ route('user.cancel.booking', ['id' => ':id']) }}".replace(':id', bookingId);
        }
    }
</script>
@endsection
       
