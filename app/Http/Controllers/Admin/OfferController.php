<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\offerRequest;
use App\Models\Notification;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = DB::table('offers')->orderBy('created_at', 'desc')->paginate(8);
        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();

       return view('admin.offers.index',compact('offers','notifications','notificationCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();

        return view('admin.offers.create',compact('notifications','notificationCount'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(offerRequest $request)
    {

         $validatedData = $request->validated();
         
         $offer = new Offer();
         $offer->offer_name = $validatedData['offer_name'];
         $offer->discount_percentage = $validatedData['discount_percentage'];
         $offer->start_date = $validatedData['start_date'];
         $offer->end_date = $validatedData['end_date'];
 
         // Save the Offer to the database
         $offer->save();
        return redirect()->route('admin.offers.index')->with('success', 'New offer added.');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $offer = Offer::find($id);
        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();

        return view('admin.offers.edit',compact('offer','notifications','notificationCount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {

        $offer = Offer::find($id);
         
          $offer->offer_name = $request['offer_name'];
          $offer->discount_percentage = $request['discount_percentage'];
          $offer->start_date = $request['start_date'];
          $offer->end_date = $request['end_date'];
  
          // Save the Offer to the database
          $offer->save();
         return redirect()->route('admin.offers.index')->with('success', ' offer updated.');
    }

    public function updateOfferStatus(Request $request, $id){

        $offer = Offer::find($id);

        $status = 0;

        $offer->update(['status' => $status]);
        
        return redirect()->route('admin.offers.index')->with('success', 'Updated.');    

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $offer = Offer::find($id);

         if (!$offer) {
            return response()->json(['error' => 'Issue list not found'], 404);
        }
        $offer->delete();
        return response()->json(['success' => 'Data deleted successfully']);
    }
}
