
@extends('user.layouts.master')
@section('content')
<link rel="stylesheet" href="{{url('assets/user/profile.css')}}">
<section class="content">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="max-w-md mx-auto">
                        @include('user.profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="max-w-md mx-auto">
                        @include('user.profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="max-w-md mx-auto">
                        @include('user.profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection