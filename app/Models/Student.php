<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Borrowing;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',   // WAJIB ADA
        'name',
        'nis',
        'class',
        'major',
        'address',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}