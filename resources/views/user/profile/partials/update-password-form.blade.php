<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('user.password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div  class="form-group row">
            <x-input-label for="update_password_current_password" class="col-sm-2 col-form-label" :value="__('Current Password')" />
            <div class="col-sm-10">
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" style="color: red; list-style:none;"/>
            </div>

        <div  class="form-group row">
            <x-input-label for="update_password_password" class="col-sm-2 col-form-label" :value="__('New Password')" />
            <div class="col-sm-10">
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" style="color: red; list-style:none; "/>
                
        </div>

        <div  class="form-group row">
            <x-input-label for="update_password_password_confirmation" class="col-sm-2 col-form-label" :value="__('Confirm Password')" />
            <div class="col-sm-10">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" style="color: red; ist-style:none;"/>

        
        </div>

        <div class="flex items-center gap-4">
            <button class="submit">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
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
