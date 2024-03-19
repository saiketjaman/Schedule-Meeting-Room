<?php
namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use Illuminate\Http\Request;

class MeetingRoomController extends Controller
{
    public function index()
    {
        return MeetingRoom::all();
    }
    public function store(Request $request)
    {
        // Validation to prevent overlapping meetings
        $request->validate([
            'meeting_title' => 'required',
            'customer_name' => 'required',
        ]);

        // Additional logic to check for overlapping meetings

        $meetingRoom = MeetingRoom::create($request->all());

        return response()->json($meetingRoom, 201);
    }
}
