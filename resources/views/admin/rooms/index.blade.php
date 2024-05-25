@extends('admin.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ url('../assets/admin/css/student_list.css') }}">
<link rel="stylesheet" href="{{ url('../assets/admin/css/room_view.css') }}">

<!-- Main content -->
    <section class="content">
        <div class="main_div" style="max-width:1564px">
            <div class="sale_list">
                <button class="add_btn" > <a href="{{route('admin.rooms.create')}}" style=" color: #fff;"> + New Entry</a></button><br>
                @if (session('success'))
                <div class="alert alert-success" style="color: red; text-align:center;">
                    {{ session('success') }}
                </div>
                @endif
                <div class="row">
                    @foreach ($rooms as $room)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                 <!-- Image Section -->
                                 <div class="card-section">
                                    <h6 class="section-title">Images:</h6>
                                    @foreach ($room->images as $image)
                                        <img class="room_image" src="{{ asset('storage/uploads/' . $image->image_path) }}" alt="Room Image">
                                    @endforeach
                                </div>
                                <h5 class="card-title">{{ $room->room_number }}</h5>

                                <div class="card-text">
                                    <p >{{ $room->roomType->name  }}  
                                    @foreach ($room->beds as $bed)
                                        <p> {{ $bed->bed_type }} Room</p>
                                    @endforeach</p>
                                </div>
                                <!-- Room Info Section -->  
                                <div class="card-section">
                                    <h6 class="section-title">Room Info: </h6>
                                    <p>Room Count : {{ $room->room_count }}</p>
                                    <p>Room Size : {{ $room->room_size }}</p>
                                    @foreach ($room->beds as $bed)
                                        <p>Bed: {{ $bed->bed_type }} bed </p>
                                        <p>Occupancy: Adult:{{ $bed->adult_capacity }} Child: {{ $bed->child_capacity }}</p>
                                    @endforeach
                                    <p>Description : {{ $room->description }}</p>
                                    <p>Price: {{ $room->price }}</p>
                                </div>
                                <!-- Facility Section -->
                                <div class="card-section">
                                    <h6 class="section-title">Facilities:</h6>
                                    <div class="facility-container">
                                        @foreach ($room->facilities as $facility)
                                            <p>{{ $facility->name }}</p>
                                        @endforeach
                                    </div>
                                </div>
                               
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.rooms.edit', ['id' => $room->id]) }}" class="btn btn-primary">Edit</a>
                                <form action="" method="POST" class="delete-form" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-book">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
            </div>
        </div>
    </section>

@endsection
