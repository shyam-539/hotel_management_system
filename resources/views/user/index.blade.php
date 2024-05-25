
@extends('user.layouts.master')
@section('content')
<link rel="stylesheet" href="{{url('assets/user/facility.css')}}">
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- Header -->
        <header class="w3-display-container w3-content" style="max-width:1500px;">
            <img class="w3-image" src="/storage/images/hotel.jpg" alt="The Hotel" style="min-width:1000px" width="1500" height="800">
            <div class="w3-display-left w3-padding w3-col l6 m8">
                <div class="w3-container w3-red">
                    <h2><img src="../storage/images/logo11.png" alt=""></i>Travancore</h2>
                </div>
                <div class="w3-container w3-white w3-padding-16">
                    <form action="{{ route('user.rooms.index') }}" method="get">
                        <div class="w3-row-padding" style="margin:0 -16px;">
                            <div class="w3-half w3-margin-bottom">
                            <label><i class="fa fa-calendar-o"></i> Check In</label>
                            <input id="checkin" name="checkin" class="w3-input w3-border" value="{{old('checkin')}}" placeholder="dd/mm/yy"  type="text">
                        </div>
                            <div class="w3-half">
                                <label><i class="fa fa-calendar-o"></i> Check Out</label>
                                <input id="checkout" name="checkout" class="w3-input w3-border" value="{{old('checkout')}}" placeholder="dd/mm/yy" type="text">
                            </div>
                        </div>
                        <div class="w3-row-padding" style="margin:8px -16px;">
                            <div class="w3-half w3-margin-bottom">
                                <label><i class="fa fa-male"></i> Adults</label>
                                <input name="adults" class="w3-input w3-border" type="number"  value="{{old('adults')?? 1 }}" >
                            </div>
                            <div class="w3-half">
                                <label><i class="fa fa-child"></i> Kids</label>
                                <input name="kids" class="w3-input w3-border" type="number" value="{{ old('kids') ?? 0 }}" >
                            </div>
                        </div>
                        <button class="w3-button w3-dark-grey" type="submit"><i class="fa fa-search w3-margin-right"></i> Search availability</button>
                    </form>
                </div>
            </div>
        </header>
        
        <!-- Page content -->
        <div class="w3-content" style="max-width:1532px;">
        
            <div class="w3-container w3-margin-top" id="rooms">
                <h3>Rooms</h3>
                <p>Make yourself at home is our slogan. We offer the best beds in the industry. Sleep well and rest well.</p>
            </div>
            
            <form action="{{ route('user.rooms.index') }}" method="get">
                <div class="w3-row-padding">
                    <div class="w3-col m3">
                        <label><i class="fa fa-calendar-o"></i> Check In</label>
                        <input id="checkinn" name="checkin" class="w3-input w3-border" value="{{old('checkin')}}" placeholder="dd/mm/yy"  type="text">
                        @error('checkin')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="w3-col m3">
                        <label><i class="fa fa-calendar-o"></i> Check Out</label>
                        <input id="checkoutt" name="checkout" class="w3-input w3-border" value="{{old('checkout')}}" placeholder="dd/mm/yy" type="text">
                        @error('checkout')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
            
                    <div class="w3-col m2">
                        <label><i class="fa fa-male"></i> Adults</label>
                        <input name="adults" class="w3-input w3-border" type="number"  value="{{old('adults')?? 1}}" placeholder="1">
                        @error('adults')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="w3-col m2">
                        <label><i class="fa fa-child"></i> Kids</label>
                        <input name="kids" class="w3-input w3-border" type="number" value="{{old('kids')?? 0}}" placeholder="0">
                        @error('kids')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="w3-col m2">
                        <label><i class="fa fa-search"></i> Search</label>
                        <button type="submit" class="w3-button w3-block w3-black">Search</button>
                    </div>
                </div>
            </form>
            
        
            <div class="w3-row-padding w3-padding-16">
                <div class="w3-row-padding w3-padding-16">
                    @foreach($rooms as $room)
                    <div class="w3-third w3-margin-bottom">
                        <img src="{{ asset('storage/uploads/'. $room->images->first()->image_path) }}" alt="{{ $room->type }}" style="width:100%; height:300px;">
                        <div class="w3-container w3-white">
                            <h3>{{ $room->roomType->name }} {{ $room->beds->first()->bed_type }} Room</h3>
                            <h6 class="w3-opacity">From ${{ $room->price }}</h6>
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
                                        <div class="room-images">
                                            @foreach ($room->images as $image)
                                                <img class="room_image" src="{{ asset('storage/uploads/' . $image->image_path) }}" alt="Room Image">
                                            @endforeach
                                        </div>
                                        <div class="room-facility">
                                            
                                            <h3>Facilities :</h3>
                                            @foreach ($room->facilities as $facility)
                                                <p>{{ $facility->name }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                </div>
            </div>
                
        
             <!-- Footer -->
             <footer class="w3-padding-32 w3-black w3-center w3-margin-top">
                <h5>Find Us On</h5>
                <div class="w3-xlarge w3-padding-16">
                    <i class="fa fa-facebook-official w3-hover-opacity"></i>
                    <i class="fa fa-instagram w3-hover-opacity"></i>
                    <i class="fa fa-snapchat w3-hover-opacity"></i>
                    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
                    <i class="fa fa-twitter w3-hover-opacity"></i>
                    <i class="fa fa-linkedin w3-hover-opacity"></i>
                </div>
                <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank" class="w3-hover-text-green">w3.css</a></p>
            </footer>
            
            <!-- Add Google Maps -->
            <script>
                function myMap() {
                    myCenter=new google.maps.LatLng(41.878114, -87.629798);
                    var mapOptions= {
                    center:myCenter,
                    zoom:12, scrollwheel: false, draggable: false,
                    mapTypeId:google.maps.MapTypeId.ROADMAP
                    };
                    var map=new google.maps.Map(document.getElementById("googleMap"),mapOptions);
                
                    var marker = new google.maps.Marker({
                    position: myCenter,
                    });
                    marker.setMap(map);
                }

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
                    
                    $( "#checkinn" ).datepicker({
                        dateFormat: 'dd-mm-yy',
                        minDate: 0, 
                        onSelect: function(selectedDate) {
                            var endDate = $( "#checkinn" ).datepicker( "getDate" );
                            endDate.setDate(endDate.getDate() + 1); 
                            $( "#checkoutt" ).datepicker( "option", "minDate", endDate );
                        }
                    });
                    $( "#checkoutt" ).datepicker({
                        dateFormat: 'dd-mm-yy',
                        minDate: 1, 
                    });
                });
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>
    
            
                          
        </div>
      @endsection
       
