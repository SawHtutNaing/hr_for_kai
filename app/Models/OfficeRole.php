<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficeRole extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'payscale_id'];

    public function payscale()
    {
        return $this->belongsTo(Payscale::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
