<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'check_in', 'check_out', 'hours_worked', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
