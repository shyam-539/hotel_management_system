
@extends('user.layouts.master')
@section('content')
<link rel="stylesheet" href="{{url('assets/user/rating_style.css')}}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
<div class="w3-content" style="max-width:1532px;">
    @if (session('success'))
        <div class="alert alert-success" style="color: #ffffff; text-align: center; padding: 15px;  background: #f12600;">
            {{ session('success') }}
        </div>
    @endif
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-start mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate">
                    <h2 class="mb-4" style="margin-top:40px">Add Review </h2>
                </div>
            </div>
        </div>
        <form action="{{route('user.rating.update',['id' => $rating->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="hidden" class="form-control" id="booking_id" name="booking_id"
                value="{{$booking_id}}" readonly>
            </div>       

            <div class="form-group">
                <label for="review">Review:</label>
                <textarea name="comments" id="comments" cols="30" rows="5"class="form-control" placeholder="Write Your Reviews" >{{$rating->comments}}</textarea>
                @error('comments')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="rating">Rating:</label>
                <div class="rating">                         
                    <input type="radio" id="star1" name="rating" value="5" {{$rating->rating == 5 ? 'checked' : ''}}>
                    <label for="star1">☆</label>
                    <input type="radio" id="star2" name="rating" value="4" {{$rating->rating == 4 ? 'checked' : ''}}>
                    <label for="star2">☆</label>
                    <input type="radio" id="star3" name="rating" value="3" {{$rating->rating == 3 ? 'checked' : ''}}>
                    <label for="star3">☆</label>                 
                    <input type="radio" id="star4" name="rating" value="2" {{$rating->rating == 2 ? 'checked' : ''}}>
                    <label for="star4">☆</label>
                    <input type="radio" id="star5" name="rating" value="1" {{$rating->rating == 1 ? 'checked' : ''}}>
                    <label for="star5">☆</label>
                </div>
                @error('rating')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    
   
    </section>
</div>

@endsection
       
