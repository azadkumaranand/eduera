<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['test_id', 'question', 'answer'];

    public function testResults()
    {
        return $this->hasMany(TestResult::class, 'question_id');
    }
}
