<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form> --}}

    <form method="post" action="{{ route('user.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label" :value="__('Name')" >Name </label>
            <div class="col-sm-10">
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div  class="form-group row">
            <label for="email" class="col-sm-2 col-form-label" :value="__('Email')" >Email</label>
            <div class="col-sm-10">
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div  class="form-group row">
            <label for="phone" class="col-sm-2 col-form-label" :value="__('Phone')" >Phone</label>
            <div class="col-sm-10">
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autocomplete="name" />
            </div>
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />

        </div>

        <div class="flex items-center gap-4">
            <button class="submit">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                    style="color: green"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
