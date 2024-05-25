<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomRequest;
use App\Models\Bed;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\LookupFacility;
use App\Models\LookupRoom;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RoomControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with(['beds', 'facilities', 'images', 'roomType'])
                ->orderBy(Room::getTableName() . '.created_at', 'desc')
                ->paginate(6);

        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();


        return view('admin.rooms.index',compact('rooms','notifications','notificationCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lookupRooms = DB::table('lookup_rooms')->get();
        $beds = DB::table('beds')->get();
        $lookupFacilities = DB::table('lookup_facilities')->get();

        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();

        return view('admin.rooms.create',compact('lookupRooms','beds','lookupFacilities','notifications','notificationCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(RoomRequest $request)
    {
        $validatedData = $request->validated();
    
        $room = Room::create([
            'lookuproom_id' => $validatedData['lookuproom_id'],
            'room_number' => " ",
            'room_count' => $validatedData['room_count'],
            'room_size' => $validatedData['room_size'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
        ]);
    
        foreach ($request->selected_bed_ids as $selectedBedId) {
            $room->beds()->attach($selectedBedId);
        }
    
        if (isset($validatedData['facility_ids'])) {
            $room->facilities()->attach($validatedData  ['facility_ids']);
        }
    
        foreach ($validatedData['images'] as $image) {

            $extension = $image->getClientOriginalExtension();

            $filename =  uniqid().'.'.$extension;

            $path = 'storage/uploads/';
            $image->move($path, $filename);
        
            RoomImage::create([
                'room_id' => $room->id,
                'image_path' => $filename,
            ]);
        }
        $lastRoomId = $room->id;

        $nextRoomNumber = 'SR' . sprintf('%03d', $lastRoomId);

        $room->update(['room_number' => $nextRoomNumber]);
    
        return redirect()->back()->with('success', 'Room created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        $lookupRooms = LookupRoom::all();
        $beds = Bed::all();
        $lookupFacilities = LookupFacility::all();

        $userId = auth()->user()->id;
        $notifications = Notification::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();

        $notificationCount = Notification::where('receiver_id', $userId)
        ->where('status', 1)
        ->count();

        return view('admin.rooms.edit', compact('room', 'lookupRooms', 'beds', 'lookupFacilities','notifications','notificationCount'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        // Update room details
        $room->update([
            'lookuproom_id' => $request['lookuproom_id'],
            'room_count' => $request['room_count'],
            'room_size' => $request['room_size'],
            'description' => $request['description'],
            'price' => $request['price'],
        ]);
    
        foreach ($request->selected_bed_ids ?? [] as $selectedBedId) {
            $room->beds()->sync($selectedBedId);
        }
        
        if (isset($request['facility_ids'])) {
            $room->facilities()->sync($request['facility_ids']);
        } else {
            $room->facilities()->detach(); 
        }
    
        if ($request->hasFile('images')) {
            foreach ($request['images'] as $image) {
                $extension = $image->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $path = 'storage/uploads/';
                $image->move($path, $filename);
    
                // Create or update image record
                $room->images()->create(['image_path' => $filename]);
            }
        }
    
        return redirect()->route('admin.rooms.view')->with('success', 'Room updated successfully.');
    
    }

   
}
