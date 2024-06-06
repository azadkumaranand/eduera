<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Chapter;
use App\Models\ChapterContent;
use Illuminate\Support\Facades\DB;


class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message'=>'your are on chapter index page'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
        ]);

        $chapter = Chapter::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('chapter.customize', ['id'=>base64_encode($request->course_id)])->with('success', 'Chapter Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        // $chapter = Chapter::find(base64_decode($id));
        $chapter = Chapter::where('chapters.id', '=', base64_decode($id))
                            ->join('chapter_contents', 'chapters.id', 'chapter_contents.chapter_id')
                            ->select(
                                'chapters.title as chapter_title',
                                'chapters.description as chapter_desc',
                                'chapter_contents.title as content_title',
                                'chapter_contents.body as content_desc',
                                'chapters.id as chapter_id',
                                'chapter_contents.id as content_id',
                                'chapters.course_id as course_id'
                            )
                            ->get();
        
        if(count($chapter)<=0){
            $chapter = Chapter::findorfail(base64_decode($id));
            // $content = 
            // return $chapter;
            
            $modifiedarray = (object)[
                'chapter_id'=>$chapter->id,
                'chapter_title'=>$chapter->title,
                'chapter_desc'=>$chapter->description,
                'course_id'=>$chapter->course_id
            ];
            $newarr = [$modifiedarray];
            // return $newarr;
            return view('teacher.customize.chapter', ['chapter'=>$newarr]);
        }
        // return $chapter;

        return view('teacher.customize.chapter', ['chapter'=>$chapter]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // $request->validate([
    //     'title' => 'required|string|max:255',
    //     'description' => 'nullable|string',
    //     'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     'video' => 'required|mimes:mp4,mov,ogg,qt|max:20000',
    //     'course_id' => 'required|exists:courses,id',
    // ]);

    $chapter = Chapter::find($id);

    DB::beginTransaction();

    // return response()->json([
    //     'message'=> 'called update',
    // ]);

    try {
        // Update chapter details
        $chapter->title = $request->title;
        $chapter->description = $request->description;
        $chapter->save();

        DB::commit();

        return response()->json([
            'message' => 'Woo! Chapter has been updated.',
            'chapter' => $chapter,
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'An error occurred while updating the chapter.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function contentCustomize(string $id){
        $content = ChapterContent::findorfail(base64_decode($id));
        // return $content;
        return view('teacher.customize.content', ['content'=>$content]);
    }
}
