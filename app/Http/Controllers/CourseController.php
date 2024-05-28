<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return view('teacher.courses.page', ['courses'=>$courses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.create.page');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description'=>'required|string',
            'price'=>'required|numeric',
        ]);
        // return response()->json([
        //     'message'=>"Your form is going to store",
        // ]);
        DB::beginTransaction();
        try {
            $course = Course::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'teacher_id'=>Auth::id(),
                'price'=>$request->price,
            ]);
            DB::commit();
            return redirect()->route('courses.index')->with('success', 'Course created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::find(base64_decode($id));
        $chapters = Chapter::where('course_id', $course->id)->get();
        return view('teacher.customize.page', ['course'=>$course, 'chapters'=>$chapters]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description'=>'required|string',
            'price'=>'required|numeric',
        ]);
        
        $course = Course::find(base64_decode($id));
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
