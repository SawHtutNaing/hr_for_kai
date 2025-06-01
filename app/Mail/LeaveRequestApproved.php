<?php

namespace App\Mail;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $leaveRequest;

    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function build()
    {
        return $this->subject('Leave Request Approved')
                    ->view('email.leave_approved')
                    ->with([
                        'user' => $this->leaveRequest->user,
                        'start_date' => $this->leaveRequest->start_date,
                        'end_date' => $this->leaveRequest->end_date,
                        'reason' => $this->leaveRequest->reason,
                    ]);
    }
}
