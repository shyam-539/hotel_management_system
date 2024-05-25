<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileControler extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth:web');
    }
  
   /**
    * Show the form for editing the specified resource.
    */
   public function edit(Request $request): View
   {
       $user = Auth::guard('web')->user();
       $userId = auth()->user()->id;
       $notifications = Notification::where('receiver_id', $userId)->get();


        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();
       return view('user.profile.edit', compact('user','notifications','notificationCount'));
   }

   /**
    * Update the specified resource in storage.
    */

    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();
    
        $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => [ 'required', 'email',Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'digits:10', 'regex:/[6789][0-9]{9}/', Rule::unique('users')->ignore($user->id) ],
           
        ]);
    
        $data = [
            'first_name' => $request->first_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
    
        DB::table('users')
            ->where('id', $user->id)
            ->update($data);
    
        return redirect()->route('user.profile.edit')->with('status', 'profile-updated');
    }
    
}
