
@extends('user.layouts.master')
@section('content')
<link rel="stylesheet" href="{{url('assets/user/booking.css')}}">

</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
<div class="w3-content" style="max-width:1532px;">
    <div class="room-list">
        @if (session('success'))
            <div class="alert alert-success" style="color: red; text-align:center;">
                {{ session('success') }}
            </div>
        @endif
        <form id="bookingForm" action="{{route('user.room.confirm.booking', ['id' => $room->id])}}" method="POST">
            @csrf
            <div class="room">
                <div class="room-details">
                    <div class="user-detail">
                        <label for="full-name">Full Name:</label>
                        <input type="text" id="full-name" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" readonly>
                    </div>
                    <div class="user-detail">
                        <label for="email">Email:</label>
                        <input type="email" id="email" value="{{ Auth::user()->email }}" readonly>
                    </div>
                    <div class="user-detail">
                        <label for="phone-number">Phone number:</label>
                        <input type="tel" id="phone-number" value="{{ Auth::user()->phone }}" readonly>
                    </div>
                    <div class="user-detail">
                        <label for="state">State:</label>
                        <input type="text" id="state" value="{{ Auth::user()->state }}" readonly>
                    </div>
                </div>
                
                
                <div class="room-image">
                    <img src="{{ asset('storage/uploads/'. $room->images->first()->image_path) }}" alt="{{ $room->type }}" >
                    <div class="room-imagess">
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
                    
                    </div>
                </div>
           
                <div class="price-details">
                    <div class="dates" style="display: flex;justify-content: space-between;">
                        <h6 class="check-in-check-out">{{ $checkin }}- {{ $checkout }}</h6>
                        <h6>{{ $numberOfNights }} Night(s)</h6>
                   
                    </div>
                    <h6 class="check-in-check-out">{{ $adultCount }} Adults, {{ $kidsCount }} Kids</h6>

                    @if($commonOffer)
                        <div class="common-offer">
                            <p>{{ $commonOffer->offer_name }} : <span style="color: red;"> {{ $commonOffer->discount_percentage }} % Off</span> </p>
                        </div>
                    @endif
                    <h6 class="room-price">From ${{ $room->price }}</h6>
    
                    @if($commonOffer)
                        @php
                            $totalPrice = $room->price ;
                            $totalPrice -= ($totalPrice * $commonOffer->discount_percentage / 100);
                        @endphp
                        <p class="offer-price">Offer price: <span style="color: red; font-size:25px;">${{ $totalPrice  }}</span> </p>
                    @endif
                    <div class="room-count">
                        <label class="room_count">Room Count:</label>
                        <input id="roomCount" type="number" name="roomCount" value="1" min="1" max="{{ $availableRoomCount }}" onchange="calculatePrice()">
                    </div>
                    @error('roomCount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    
                    <div class="extra-bed">
                        <label class="extra_bed">Extra Bed (250/bed) : </label>
                        <input id="extraBedCount" name="extraBedCount" type="number" value="0" min="0" max="3" onchange="calculatePrice()">
                    </div>
                    @error('extraBedCount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <h6 class="total-price" name="totalPrice">Total Price: $<span id="totalPrice" name="totalPrice">{{ $totalPrice }}</span></h6>
                    <input type="hidden" name="totalPrice" id="totalPriceInput" value="{{ $totalPrice }}">
                    @error('totalPrice')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <h6 class="tax-percentage">Tax Percentage: {{ $taxPercentage }}%</h6>
                    <h6 class="tax-amount">Tax Amount: $<span id="taxAmount">{{ $taxAmount }}</span></h6>
                    <input type="hidden" name="taxAmount" id="taxAmountInput" value="{{ $taxAmount }}">
                    @error('taxAmount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <h6 class="net-amount">Net Amount: $<span id="netAmountt" style="color: red;font-size: x-large;">{{ $netAmount }}</span></h6>
                    <input type="hidden" id="netAmount" name="netAmount" value="{{ $netAmount }}">
                    @error('netAmount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="redeem-points" style="display:flex;">
                        <h6 class="redeem-points">Redeem Points :{{ Auth::user()->total_points }}</h6>
                        <input type="checkbox" id="redeemCheckbox" name="redeem_points" onclick="redeemPoints()"  style=" width: 60px; font-size: x-small; height: 20px;margin: auto;"">
                    </div>
                    <input type="hidden" name="taxPercentage" value="{{ $taxPercentage }}">

                    <input type="hidden" name="checkin" value="{{ $checkin }}">
                    <input type="hidden" name="checkout" value="{{ $checkout }}">
                    <input type="hidden" name="adultCount" value="{{ $adultCount }}">
                    <input type="hidden" name="kidsCount" value="{{ $kidsCount }}">
                    <input type="hidden" name="availableRoomCount" value="{{ $availableRoomCount }}">

                    <button class="book-now-button" onclick="confirmBooking()">Confirm Booking</button>
                </div>
                   
                </div>
            </div>
        </form>
        <div class="review">
            @foreach($roomReviews as $review)
            <div class="review-item">
                <div class="user-info">
                    <span class="user-name">{{ $review->booking->user->first_name }} {{ $review->booking->user->last_name }}</span>
                    <span class="rating"> Rating: 
                        @for ($i = 0; $i < $review->rating; $i++)
                            <span class="star">&#9733;</span>
                        @endfor
                    </span>

                </div>
                <div class="comments">{{ $review->comments }}</div>

            </div>
            @endforeach
        </div>
        
    </div>
</div>

<script>
$(document).ready(function() {
    calculatePrice();

    $('#roomCount, #extraBedCount').on('input', function() {
        calculatePrice();
    });
});

function calculatePrice() {
    var roomPrice = parseFloat("{{ $totalPrice }}");
    var numberOfNights = parseInt("{{ $numberOfNights }}");
    var extraBedPrice = 250; 

    var roomCountInput = document.getElementById('roomCount');
    var roomCount = parseInt(roomCountInput.value) || 0;

    var extraBedCountInput = document.getElementById('extraBedCount');
    var extraBedCount = parseInt(extraBedCountInput.value) || 0;

    roomCount = Math.max(roomCount, 0);
    extraBedCount = Math.max(extraBedCount, 0);

    var totalPrice = (roomPrice * numberOfNights * roomCount) + (extraBedPrice * extraBedCount);
    var taxPercentage = parseFloat("{{ $taxPercentage }}");
    var taxAmount = totalPrice * (taxPercentage / 100);
    var netAmount = totalPrice + taxAmount;

    document.getElementById('totalPrice').innerText = totalPrice.toFixed(2);
    document.getElementById('totalPriceInput').value = totalPrice.toFixed(2);
    
    document.getElementById('taxAmount').innerText = taxAmount.toFixed(2);
    document.getElementById('taxAmountInput').value = taxAmount.toFixed(2);
    
    document.getElementById('netAmount').value = netAmount.toFixed(2);
    document.getElementById('netAmountt').innerText = netAmount.toFixed(2);
}

var originalNetAmount;
function redeemPoints() {
    var redeemCheckbox = document.getElementById('redeemCheckbox');
    var netAmountInput = document.getElementById('netAmount');
    var netAmounttElement = document.getElementById('netAmountt');

    if (typeof originalNetAmount === 'undefined') {
        originalNetAmount = parseFloat(netAmountInput.value);
    }

    if (redeemCheckbox.checked) {
        var totalPoints = parseInt("{{ Auth::user()->total_points }}");
        var newNetAmount = originalNetAmount - totalPoints;

        netAmountInput.value = newNetAmount.toFixed(2);
        netAmounttElement.innerText = newNetAmount.toFixed(2);
    } else {
        netAmountInput.value = originalNetAmount.toFixed(2);
        netAmounttElement.innerText = originalNetAmount.toFixed(2);
    }
}


function confirmBooking() {
    if (confirm("Are you sure you want to confirm the booking?")) {
        document.getElementById("bookingForm").submit();
    }
}

$(document).ready(function() {
    $(document).on('submit', '#bookingForm', function(e) {
        e.preventDefault();
    });

    $('#confirmButton').click(function() {
        confirmBooking();
    });
});


</script>
@endsection
       
