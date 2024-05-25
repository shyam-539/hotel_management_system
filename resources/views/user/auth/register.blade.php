@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="{{url('../assets/css/register_style.css')}}">
<div class="main_div">
    {{-- <img src="storage/images/prove-bg.png" alt="home" class="main_img"> --}}
    <div class="login_registration_form">
        <div class="registration_details">
            <img src="{{url('../storage/images/footer5.jpeg')}}" alt="working man" class="register_img">
        </div>
        <div class="registration_details">
            <h2>Register Here</h2>
            <form action="{{ route('user.register.store') }}" method="post">
              @csrf
              <div class="user-details">
                  <div class="input-box">
                      <span class="details">First Name</span>
                      <input type="text" name="first_name" placeholder="Enter your first name" value="{{old('first_name')}}" required>
                      @error('first_name')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
          
                  <div class="input-box">
                      <span class="details">Last Name</span>
                      <input type="text" name="last_name" value="{{old('first_name')}}" placeholder="Enter your last name" >
                      @error('last_name')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
          
                  <div class="input-box">
                      <span class="details">Email</span>
                      <input type="email" name="email" value="{{old('first_name')}}" placeholder="Enter your email" required>
                      @error('email')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
          
                  <div class="input-box">
                      <span class="details">Phone Number</span>
                      <input type="text" name="phone" value="{{old('first_name')}}" placeholder="Enter your phone number" required>
                      @error('phone')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
          
                  <div class="input-box">
                      <span class="details">City</span>
                      <input type="text" name="city" value="{{old('first_name')}}" placeholder="Enter your city" required>
                      @error('city')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
          
                  <div class="input-box">
                      <span class="details">District</span>
                      <input type="text" name="district" value="{{old('first_name')}}" placeholder="Enter your district" required>
                      @error('district')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
          
                  <div class="input-box">
                      <span class="details">State</span>
                      <input type="text" name="state" value="{{old('first_name')}}" placeholder="Enter your state" required>
                      @error('state')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
          
                  <div class="input-box">
                      <span class="details">Pin Code</span>
                      <input type="text" name="pin_code" value="{{old('first_name')}}" placeholder="Enter your pin code" required>
                      @error('pin_code')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
          
                  <div class="input-box">
                      <span class="details">Password</span>
                      <input type="password" name="password"  placeholder="Enter your password" required>
                      @error('password')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
          
                  <div class="input-box">
                      <span class="details">Confirm Password</span>
                      <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
                      @error('password_confirmation')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
              </div>
          
              <div class="button">
                  <input type="submit" value="Register">
              </div>
          
              <div class="sign_in_section">
                  <span>Already have an account? <a href="{{ route('user.login') }}"> Sign in</a></span>
              </div>
          </form>
          
        </div>
    </div>
</div>
@endsection