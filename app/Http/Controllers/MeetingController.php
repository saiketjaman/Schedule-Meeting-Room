<?php
namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::join('meeting_rooms', 'meetings.id', '=', 'meeting_rooms.id')
            ->select('meetings.*', 'meeting_rooms.*')
            ->get();
        return response()->json($meetings, 200);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:meeting_rooms,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check for overlapping meetings
        $overlappingMeetings = Meeting::where('room_id', $request->room_id)
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->count();

        // If there are overlapping meetings, return error response
        if ($overlappingMeetings > 0) {
            return response()->json(['error' => 'Overlapping meetings are not allowed'], 422);
        }

        // Create the meeting
        $meeting = Meeting::create([
            'room_id' => $request->room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json($meeting, 201);
    }

    public function update(Request $request, Meeting $meeting)
    {
        $meeting->update($request->all());

        return response()->json($meeting, 200);
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return response()->json(null, 204);
    }
}

