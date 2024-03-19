<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = ['room_id', 'start_time', 'end_time'];

    public function room()
    {
        return $this->belongsTo(MeetingRoom::class);
    }
}
