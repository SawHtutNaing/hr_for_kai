<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
