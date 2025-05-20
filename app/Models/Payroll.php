<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount', 'pay_date', 'details'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
