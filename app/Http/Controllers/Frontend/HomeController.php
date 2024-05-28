<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\Test;

class HomeController extends Controller
{
    public function index(){
        $courses = Course::limit(3)->get();
        // return $course;
        $tests = Test::limit(3)->get();
        return view('frontend.page', ['courses'=>$courses, 'tests'=>$tests]);
    }

    public function courseDetails(string $id){
        $course = Course::find(base64_decode($id));
        $chapters = Chapter::where('course_id', base64_decode($id))->get();
        // return $chapter;
        return view('frontend.course.coursedetails', ['course'=>$course, 'chapters'=>$chapters]);
    }
}
