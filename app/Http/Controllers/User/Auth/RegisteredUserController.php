<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Mail\RegisterMail;
use App\Models\Loyality;
use App\Models\User;
use App\Models\UserLoyality;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('user.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
       
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
            'password' => Hash::make($request->password),
            'total_points' =>"",
        ]);
        
        $loyaltyId = 1; 
        
        $userLoyalty = UserLoyality::create([
            'user_id' => $user->id,
            'loyalty_id' => $loyaltyId,
        ]);
        
        $loyalty = Loyality::find($loyaltyId);
        
        if ($loyalty) {
            $user->update([
                'total_points' => $loyalty->points
            ]);
        }   
        
        Mail::to($user->email)->send(new RegisterMail($user));

        return redirect()->route('user.login')->with('success', 'User registered successfully!');
    
    }
}
