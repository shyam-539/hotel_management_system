
@extends('user.layouts.master')
@section('content')
<link rel="stylesheet" href="{{url('assets/user/room.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- jQuery UI -->
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="w3-content" style="max-width:1532px;">
        
    <div class="w3-container w3-margin-top" id="rooms">
        <h3>Rooms</h3>
    </div>
    @if (session('success'))
        <div class="alert alert-success" style="color: red; text-align:center;">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('user.rooms.index') }}" method="get">
        <div class="w3-row-padding">
            <div class="w3-col m3">
                <label><i class="fa fa-calendar-o"></i> Check In</label>
                <input id="checkin" name="checkin" class="w3-input w3-border" type="text" value="{{$checkin}}">
            </div>
            <div class="w3-col m3">
                <label><i class="fa fa-calendar-o"></i> Check Out</label>
                <input id="checkout"  name="checkout" class="w3-input w3-border" type="text" value="{{$checkout}}">
            </div>

            <div class="w3-col m2">
                <label><i class="fa fa-male"></i> Adults</label>
                <input id="adults" name="adults" class="w3-input w3-border" type="number" placeholder="1" value="{{$adults}}">
            </div>
            <div class="w3-col m2">
                <label><i class="fa fa-child"></i> Kids</label>
                <input id="kids" name="kids" class="w3-input w3-border" type="number" placeholder="0"value="{{$kids}}">
            </div>
            <div class="w3-col m2">
                <label><i class="fa fa-search"></i> Search</label>
                <button type="submit" class="w3-button w3-block w3-black">Search</button>
            </div>
        </div>
    </form>
   <div class="room-list">
    @foreach($availableRooms as $room)
        <div class="room">
            <div class="room-image">
                <img src="{{ asset('storage/uploads/'. $room->images->first()->image_path) }}" alt="{{ $room->type }}" >
            </div>
            <div class="room-details">
               
                <h3>{{ $room->roomType->name }} {{ $room->beds->first()->bed_type }} Room</h3>
                <p>
                    @foreach($room->beds as $bed)
                        {{ $bed->bed_type }} bed
                    @endforeach
                </p>
                @php
                    $adultCapacityTotal = 0;
                    $childCapacityTotal = 0;
                @endphp

                @foreach($room->beds as $bed)
                    @php
                        $adultCapacityTotal += $bed->adult_capacity;
                        $childCapacityTotal += $bed->child_capacity;
                    @endphp
                @endforeach

                <p>Occupancy: Adult: {{ $adultCapacityTotal }} Child: {{ $childCapacityTotal }}</p>
                <p>Property size:  {{ $room->room_size }}m<sup>2</sup></p>
                <a onclick="openModal('{{ $room->id }}')">Show Facilities</a> 
                <div id="facilitiesModal{{ $room->id }}" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('{{ $room->id }}')">&times;</span> 
                        <h3>{{ $room->roomType->name }} {{ $room->beds->first()->bed_type }} Room</h3>

                        <div class="facilities-list">

                            <div class="room-facility">
                                
                                <h3>Facilities :</h3>
                                @foreach ($room->facilities as $facility)
                                    <p>{{ $facility->name }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="room-imagess">
                    @foreach ($room->images as $image)
                        <img class="room_image" src="{{ asset('storage/uploads/' . $image->image_path) }}" alt="Room Image">
                    @endforeach
                </div>
            </div>
            <div class="price-details">
                @if($commonOffer)
                    <div class="common-offer">
                        <p>{{ $commonOffer->offer_name }} : <span style="color: red;"> {{ $commonOffer->discount_percentage }} % Off</span> </p>
                    </div>
                @endif
                <h6 class="room-price">From ${{ $room->price }}</h6>

                @if($commonOffer)
                    @php
                        $totalPrice = $room->price;
                        $totalPrice -= ($totalPrice * $commonOffer->discount_percentage / 100);
                    @endphp
                    <p class="offer-price">Offer price: <span style="color: red; font-size:25px;">${{ $totalPrice }}</span> </p>
                @endif

                @if ($adultCapacityTotal >= $adults && $childCapacityTotal >= $kids)
                    @if ($availableRoomCount[$room->id] > 0)
                        <button class="book-now-button" onclick="bookRoomWithDates('{{ $room->id }}')">Book Now</button>
                        <h6 style="color: red">Our last {{ $availableRoomCount[$room->id] }} Room{{ $availableRoomCount[$room->id] > 1 ? 's' : '' }}!</h6>
                    @else
                        <button class="sold-out-button" disabled>Sold Out!</button>
                    @endif
                @else
                    <h6 style="color: red" >Room capacity exceeded</h6>
                    <button class="book-now-button" onclick="bookRoomWithDates('{{ $room->id }}')">Book Now</button>
                    <h6 style="color: red">Our last {{ $availableRoomCount[$room->id] }} Room{{ $availableRoomCount[$room->id] > 1 ? 's' : '' }}!</h6>
                
                @endif
                <div class="rating">
                    @php
                        $totalRating = 0;
                        $ratingCount = 0;
                
                        if ($room->bookings) {
                            foreach ($room->bookings as $booking) {
                                $rating = $booking->rating;
                                if ($rating) {
                                    $totalRating += $rating->rating;
                                    $ratingCount++;
                                }
                            }
                        }
                
                        $averageRating = $ratingCount > 0 ? $totalRating / $ratingCount : 0;
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $averageRating)
                            <span class="star">&#9733;</span>
                        @else
                            <span class="star">&#9734;</span>
                        @endif
                    @endfor
                
                    <span class="average-rating">{{ number_format($averageRating, 1) }}</span> <!-- Display average rating -->
                </div>
                
            </div>
               
            </div>
        </div>
    @endforeach
</div>


<script>
     function openModal(roomId) {
        var modal = document.getElementById('facilitiesModal' + roomId);
        modal.style.display = "block";
    }

    function closeModal(roomId) {
        var modal = document.getElementById('facilitiesModal' + roomId);
        modal.style.display = "none";
    }

    $( function() {
        $( "#checkin" ).datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: 0, 
            onSelect: function(selectedDate) {
                var endDate = $( "#checkin" ).datepicker( "getDate" );
                endDate.setDate(endDate.getDate() + 1); 
                $( "#checkout" ).datepicker( "option", "minDate", endDate );
            }
        });
        $( "#checkout" ).datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: 1, 
        });
    });

    function bookRoomWithDates(roomId) {
        var roomCount = {{ $availableRoomCount[$room->id] }};
        
        if (roomCount > 0) {
            var checkinDate = document.getElementById('checkin').value;
            var checkoutDate = document.getElementById('checkout').value;
            var adultCount = document.getElementById('adults').value;
            var kidsCount = document.getElementById('kids').value;
            
            var bookingUrl = "{{ route('user.room.booking', ['id' => ':id']) }}";
            bookingUrl = bookingUrl.replace(':id', roomId) + "?checkin=" + checkinDate + "&checkout=" + checkoutDate + "&adults=" + adultCount + "&kids=" + kidsCount;            
            window.location.href = bookingUrl;
        } else {
            document.querySelector('.book-now-button').setAttribute('disabled', 'disabled');
        }
    }

</script>
@endsection
       
