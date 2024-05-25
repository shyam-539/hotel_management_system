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
                <form action="{{route('admin.loyality.update', ['id' => $loyality->id]) }}" method="POST" id="myform" >
                    @csrf
                    @method('PUT')
                    <div class="user-details">
                        <div class="input-box">
                            <span class="details">Offer Name:</span>
                            <input type="text"  id="programme_name" name="programme_name" value="{{$loyality->programme_name}}" required>
                            @error('programme_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                
                        </div>

                        <div class="input-box">
                            <span class="details">Discount Percentage</span>                       
                            <input type="text"  id="points" name="points" value="{{$loyality->points}}" required>
                            @error('points')
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
