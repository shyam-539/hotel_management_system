@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="{{url('../assets/css/login_style.css')}}">
<div class="main_div">
    {{-- <img src="storage/images/prove-bg.png" alt=""> --}}
    <div class="nav_bar">
        <button>Login</button>
    </div>
    <div class="login_registration_form">
        <div class="login_details">
            <img src="{{url('../storage/images/footer5.jpeg')}}" alt="">
        </div>
        <div class="login_details">
            <h2>Login</h2>

            <form action="{{route('user.store')}}" method="POST">
                @csrf
                <div class="user-details">
                    <div class="input-box">
                      <span class="details">Email-Id</span>
                      <input type="email" id="email" class="block mt-1 w-full" type="email" name="email" value="{{old('email')}}" required autofocus autocomplete="username">
                      @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>

                    <div class="input-box">
                      <span class="details">Password</span>
                      <input d="password" class="block mt-1 w-full"type="password"name="password"required autocomplete="current-password">
                      @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        
                        </label>
                    </div>

               
                    <div class="forgot_pwrd">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                </div>
                <div class="button">
                    <input type="submit" value="login">
                </div>
                <div class="register_form">
                    <span>Don't have an account? <a href="{{route('user.login')}}">Register here.</a></span>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection