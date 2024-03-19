<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingRoom extends Model
{
    protected $fillable = ['meeting_title', 'customer_name'];

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
