<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoyalityRequest;
use App\Models\Loyality;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoyalityControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loyalities = DB::table('loyalities')->orderBy('created_at', 'desc')->paginate(8);

        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();


        return view('admin.loyality.index',compact('loyalities','notifications','notificationCount'));
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(LoyalityRequest $request)
    {
        $validatedData = $request->validated();

        Loyality::create([
            'programme_name' => $validatedData['programme_name'],
            'points' => $validatedData['points'],
        ]);

        return redirect()->route('admin.loyality.index')->with('success', 'New Loyality added successfully.');    

    }
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $loyality = Loyality::find($id);
        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();

        return view('admin.loyality.edit',compact('loyality','notifications','notificationCount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {

        $loyality = Loyality::find($id);
          // Validate the form data

          $loyality->programme_name = $request['programme_name'];
          $loyality->points = $request['points'];
  
          // Save the Offer to the database
          $loyality->save();
         return redirect()->route('admin.loyality.index')->with('success', ' Loyality updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $loyality = Loyality::find($id);

        if (!$loyality) {
           return response()->json(['error' => 'Issue list not found'], 404);
       }
       
       $loyality->delete();
       return response()->json(['success' => 'Data deleted successfully']);
   }
}

