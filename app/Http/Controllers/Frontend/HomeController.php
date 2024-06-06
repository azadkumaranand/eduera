<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\ChapterContent;
use App\Models\Test;

class HomeController extends Controller
{
    public function index(){
        $courselContent = [
            [
                'title'=>'Master Web Development Skills',
            'description'=>'Gain hands-on experience with HTML, CSS, and JavaScript. Build stunning, responsive websites from scratch with our beginner-friendly courses. Start your web development journey today!'
            ],
            [
                'title'=>'Dive into Backend Programming',
            'description'=>'Learn PHP and MySQL to create dynamic and robust web applications. Our courses provide in-depth knowledge to transform you into a backend expert. Enroll now and start coding!'
            ],
            [
                'title'=>'Explore Modern Frameworks',
            'description'=>'Get proficient with Laravel and React. Understand how to use these powerful frameworks to develop complex web applications efficiently. Join us to stay ahead in the tech world!
    
            '
            ],
            [
                'title'=>'Become a Full-Stack Developer',
            'description'=>'Master both frontend and backend development with our comprehensive curriculum. From creating interactive UIs to managing databases, become a versatile full-stack developer with CodeMintro.'
            ],
        ];
        $courses = Course::where('status', 'publish')->limit(3)->get();
        // return $course;
        $tests = Test::where('status', 'publish')->limit(3)->get();
        return view('frontend.page', ['courses'=>$courses, 'tests'=>$tests, 'crousel'=>$courselContent]);
    }
    public function about(){
        $courses = Course::limit(3)->get();
        // return $course;
        $tests = Test::limit(3)->get();
        return view('frontend.pages.about', ['courses'=>$courses, 'tests'=>$tests]);
    }

    public function allCourse(){
        $courses = Course::where('status', 'publish')->get();
        return view('frontend.pages.courses', ['courses'=>$courses]);
    }

    public function courseDetails(string $id){
        $course = Course::find(base64_decode($id));
        $chapters = Chapter::where('course_id', base64_decode($id))->get();
        // return $chapter;
        return view('frontend.course.coursedetails', ['course'=>$course, 'chapters'=>$chapters]);
    }

    public function chapterDetails(string $id){
        // $chapter = Chapter::findorfail(base64_decode($id));

        $result = Chapter::where('chapters.id', '=', base64_decode($id))
                            ->join('chapter_contents', 'chapters.id', 'chapter_contents.chapter_id')
                            ->select(
                                'chapters.id as chapter_id',
                                'chapter_contents.id as content_id',
                                'chapters.title as chapter_title',
                                'chapters.description as chapter_desc',
                                'chapter_contents.title as content_title',
                                'chapter_contents.body as content_desc',
                            )
                            ->orderBy('content_order', 'asc')
                            ->get();
        // return $result;
        if(count($result)>0){
            return view('frontend.course.chapterdetails', ['result'=>$result]);
        }
        return redirect()->back();
    }
}
