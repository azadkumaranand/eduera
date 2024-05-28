<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Chapter;
use App\Models\Attachment;
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
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:20000',
            'course_id' => 'required|exists:courses,id',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $videoPath = $request->file('video')->store('videos', 'public');

        $chapter = Chapter::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
        ]);
        $attachment = Attachment::create([
            'course_id' => $request->course_id,
            'chapter_id'=> $chapter->id,
            'thumbnail' => $thumbnailPath,
            'video' => $videoPath,
        ]);

        return response()->json([
            'title' => $chapter->title,
            'description' => $chapter->description,
            'thumbnail_url' => Storage::url($attachment->thumbnail),
            'video_url' => Storage::url($attachment->video),
        ]);
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
        $chapter = Chapter::find(base64_decode($id));
        $attachment = Attachment::where('chapter_id', base64_decode($id))->first();
        return view('teacher.customize.chapter', ['chapter'=>$chapter, 'attachment'=>$attachment]);
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
    $attachment = Attachment::where('chapter_id', $id)->first();

    DB::beginTransaction();

    // return response()->json([
    //     'message'=> 'called update',
    // ]);

    try {
        // Update chapter details
        $chapter->title = $request->title;
        $chapter->description = $request->description;
        $chapter->save();

        // Delete old files from storage
        Storage::disk('public')->delete($attachment->thumbnail);
        Storage::disk('public')->delete($attachment->video);

        // Store new files in storage
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $videoPath = $request->file('video')->store('videos', 'public');

        // Update attachment details
        $attachment->video = $videoPath;
        $attachment->thumbnail = $thumbnailPath;
        $attachment->save();

        DB::commit();

        return response()->json([
            'message' => 'Woo! Chapter has been updated.',
            'chapter' => $chapter,
            'attachment' => $attachment,
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
}
