<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chapter;

class ChapterContent extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'chapter_id', 'body', 'content_order'];

    public function chapters(){
        return $this->hasMany(Chapter::class, 'id');
    }
}
