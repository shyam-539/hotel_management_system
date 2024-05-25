<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
   public function index()  {

    $rooms = Room::with(['beds', 'facilities', 'images'])->get();
      
    return view('welcome', compact('rooms'));
   }
}
