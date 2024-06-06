<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'test_type', 'thumbnail'];

    public function testResults(){
        return $this->hasMany('test_results', 'test_id');
    }
    public function questions(){
        return $this->hasMany('questions', 'test_id');
    }
    public function options(){
        return $this->hasMany('options', 'test_id');
    }
}
