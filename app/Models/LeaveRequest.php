<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveRequestApproved;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'start_date', 'end_date', 'reason', 'status', 'approved_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
       public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($leaveRequest) {
            if ($leaveRequest->isDirty('status') && $leaveRequest->status === 'approved') {
                Mail::to($leaveRequest->user->email)->send(new LeaveRequestApproved($leaveRequest));
            }
        });
    }


}
