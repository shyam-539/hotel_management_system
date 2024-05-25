@extends('admin.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ url('../assets/admin/css/student_form.css') }}">

<!-- Main content -->
    <section class="content">
        <div class="main_div" style="max-width:1564px">
            <div class="sale_list">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <h2>Offer Form</h2>
                <!-- form begin here -->
                <form action="{{route('admin.offers.store')}}" method="POST" id="myform" >
                    @csrf
                    <div class="user-details">
                        <div class="input-box">
                            <span class="details">Offer Name:</span>
                            <input type="text"  id="offer_name" name="offer_name" value="{{old('offer_name')}}" required>
                            @error('offer_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                
                        </div>

                        <div class="input-box">
                            <span class="details">Discount Percentage</span>                       
                            <input type="text"  id="discount_percentage" name="discount_percentage" value="{{old('discount_percentage')}}" required>
                            @error('discount_percentage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror               
                        </div>

                        <div class="input-box">
                            <span class="details">Start date</span>
                            <input type="date"  id="start_date" name="start_date" value="{{old('start_date')}}" required>
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-box">
                            <span class="details">End date</span>
                            <input type="date"  id="end_date" name="end_date" value="{{old('end_date')}}" required>
                            @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="button">
                        <input type="submit" name="submit_btn" value="Submit">
                    </div>
                    
                </form> 
            </div>
        </div>
    </section>
        <!-- ./wrapper -->
 
@endsection
