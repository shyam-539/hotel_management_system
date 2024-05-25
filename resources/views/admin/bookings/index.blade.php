@extends('admin.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ url('../assets/css/booking_view.css') }}">

<!-- Main content -->
    <section class="content">
        <div class="main_div" style="max-width:1564px">
            @if (session('success'))
            <div class="alert alert-success" style="color: red; text-align:center;">
                {{ session('success') }}
            </div>
            @endif
            <label for="search">Search booking Here : </label>
            <input type="text" id="searchQuery" name="search" placeholder="Search booking here" value="{{ request('search') }}">
            <form action="{{ route('admin.bookings.index') }}"id="searchForm" method="GET" style="display: inline;">
                <input type="date" id="searchDate" name="searchDate" placeholder="Search book here" value="{{ request('searchDate') }}">
                <button type="submit" class="search_btn"><i class="fa fa-search"></i></button>
            </form>
    
            <div class="room-list">
                @foreach ($bookings as $booking)
                    <div class="room">
                        <div class="room-details">
                            <div class="user-detail">
                                <h4>Customer Details</h4>
                                <p for="full-name">Full Name: {{ $booking->user->first_name }} {{ $booking->user->last_name }}</p>
                                <p for="full-name">Email Id: {{ $booking->user->email }} </p>
                                <p for="full-name">Mobile: {{ $booking->user->phone }} </p>
                                <p for="full-name">State: {{ $booking->user->state }} </p>
                            </div>
                        </div>

                        <div class="room-image">
                            <img src="{{ asset('storage/uploads/'. $booking->room->images->first()->image_path) }}" >
                            <h3>{{ $booking->room->roomType->name }} {{ $booking->room->beds->first()->bed_type }} Room</h3>
                            <p>{{ $booking->room->beds->first()->bed_type }} bed</p>
                            <p>Persons: {{ $booking->adult_count }} Adults,  {{ $booking->child_count }} Child</p>
                            <p>Property size:  {{ $booking->room->room_size }}m<sup>2</sup></p>
                        </div>
                        <div class="room-imagess">
                            
                        </div>
                    
                        <div class="price-details">
                            <div class="dates" style="display: flex;justify-content: space-between;">
                                <h6 class="check-in-check-out">{{ $booking->check_in }} - {{ $booking->check_out }}</h6>
                                <h6>{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }}  Night(s)</h6>
                            </div>
                            
                            <div class="room-count">
                                <h6 id="roomCount"  name="roomCount" >Room Count: {{$booking->room_count}}</h6>
                            </div>
                
                            <div class="extra-bed">
                                <h6 id="extraBedCount" name="extraBedCount"  >Extra Bed: {{$booking->extra_bed}}</h6>
                            </div>
                            <h6 id="count" name="count"  >Persons: {{$booking->adult_count}} Adults {{$booking->child_count}} Kids</h6>

                            <h6 class="total-price" name="totalPrice">Total Price: $<span id="totalPrice" name="totalPrice">{{$booking->net_amount }}</span></h6>
                            
                        </div>

                        <div class="room-details">
                            @if ($booking->status==1)
                                <button class="book-now-button" onclick="cancelBooking({{ $booking->id }})">Cancel</button>

                                @if ($booking->check_in==date('Y-m-d'))
                                    <button class="book-now-button" onclick="checkInBooking({{ $booking->id }})">Check In</button> 
                                @endif

                                <h6 style="color: red;padding: 24px;font-size: larger;">{{\Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::now())}} Days to Go!</h6>
                            
                                @elseif ($booking->status==2)
                                <button class="book-now-button" onclick="checkOutBooking({{ $booking->id }})">Check Out</button> 
                            
                            @elseif ($booking->status==3)
                            <h6 style="color: red;padding: 24px;font-size: larger;">Check Out.</h6>

                            @else
                                <h6 style="color: red;padding: 24px;font-size: larger;">Cancelled!</h6>

                            @endif
                        </div>
                    </div>
                    @endforeach
                    <div id="noDataFound" style="display: none;">
                        No data found
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault(); 
                
                var form = $(this);
                var borrowURL = form.attr('action');
                var rowElement = form.closest('tr');
    
                if (confirm("Are you sure you want to delete this Record?")) {
                    $.ajax({
                        url: borrowURL,
                        type: 'DELETE',
                        dataType: 'json',
                        data: form.serialize(), 
                        success: function(data) {
                            alert(data.success); 
                            rowElement.remove(); 
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); 
                        }
                    });
                } 
            });
            $('#searchQuery').keyup(function() {
                var searchText = $(this).val().toLowerCase();
                var anyRoomFound = false; 
                
                $('.room').each(function() {
                    var roomText = $(this).text().toLowerCase();
                    var isRoomMatch = roomText.includes(searchText);
                    $(this).toggle(isRoomMatch); 
                    
                    if (isRoomMatch) {
                        anyRoomFound = true; 
                    }
                });

                if (!anyRoomFound) {
                    $('#noDataFound').show();
                } else {
                    $('#noDataFound').hide();
                }
            });

        });

        function cancelBooking(bookingId) {
            if (confirm("Are you sure you want to cancel this booking?")) {
                window.location.href = "{{ route('cancel.booking', ['id' => ':id']) }}".replace(':id', bookingId);
            }
        }
        function checkInBooking(bookingId) {
          
                window.location.href = "{{ route('checkin', ['id' => ':id']) }}".replace(':id', bookingId); 
        }
        function checkOutBooking(bookingId) {
          
            window.location.href = "{{ route('checkout', ['id' => ':id']) }}".replace(':id', bookingId);
        }
    </script>
@endsection
