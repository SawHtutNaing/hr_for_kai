<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LeaveRequestStatus extends Notification
{
    public $leaveRequest;

    public function __construct($leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Leave Request Status Update')
            ->line('Your leave request from ' . $this->leaveRequest->start_date . ' to ' . $this->leaveRequest->end_date . ' has been ' . $this->leaveRequest->status . '.')
            ->line('Reason: ' . $this->leaveRequest->reason)
            ->line('Thank you for using our HR system!');
    }
}
