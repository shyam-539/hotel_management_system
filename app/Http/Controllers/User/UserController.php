<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function index() : View {

    $rooms = Room::with(['beds', 'facilities', 'images'])->get();

    $userId = auth()->user()->id;
    
    $notifications = Notification::where('receiver_id', $userId)->get();

    $notificationCount = Notification::where('receiver_id', $userId)
                              ->where('status', 1)
                              ->count();

    return view('user.index', compact('rooms','notifications','notificationCount'));
   }

   public function edit(Request $request): View
   {
       return view('user.profile.edit', [
           'user' => $request->user(),
       ]);
   }

}
