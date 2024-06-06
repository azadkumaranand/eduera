<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChapterContent;

class ChapterContentController extends Controller
{
    public function show(){
        // return 
    }
    public function store(Request $request){
        $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'title' => 'required|string|max:255',
            'content_order' => 'required',
        ]);

        // return $request;

        $data = $request->all();

        ChapterContent::create($data);
        return redirect()->route('chapter.customize', ['id'=>base64_encode($request->chapter_id)])->with('success', 'Content created successfully.');
    }

    public function contentUpdate(Request $request){
        // return $request;
        $content = ChapterContent::findorfail($request->content_id);

        $content->title = $request->title;
        $content->body = $request->body;
        $content->content_order=$request->content_order;
        $content->save();

        return redirect()->route('content.customize', ['id'=>base64_encode($request->content_id)])->with('success', 'Content Updated Successfully!');
    }

    public function contentDelete(string $id){
        $result = ChapterContent::findorfail(base64_decode($id));
        $chapter_id = $result->chapter_id;
        // return $result;
        try {
            $isDelete = $result->delete();
            if($isDelete){
                return redirect()->route('chapter.customize', ['id'=>base64_encode($chapter_id)])->with('success', 'Content Deleted Successfully!');
            }else{
                throw "Something went wrong not deleated";
            }
        } catch (\Throwable $th) {
            throw "Error during deleting content: ".$th;
        }
        
    }
}
