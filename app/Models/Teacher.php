<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public function subject()
{
    return $this->belongsTo(Subject::class);
}

    protected $fillable = ['name', 'nip', 'email', 'phone', 'subject_id', 'photo'];
    
}

