<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payscale extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'salary'];

    public function officeRoles()
    {
        return $this->hasMany(OfficeRole::class);
    }
}
