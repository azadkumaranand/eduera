<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'teacher_id', 'description', 'thumbnail', 'price'];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
