<?php

namespace App\Http\Controllers;
use App\Models\Test;
use App\Models\Option;
use App\Models\Question;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;
use Auth;

use Illuminate\Http\Request;



class TestController extends Controller
{
    public function show(){
        $tests = Test::all();
        // return response()->json([
        //     'message'=>$tests,
        // ]);
        return view('teacher.tests.page', ['tests'=>$tests]);
    }

    public function showmcqpage(){
        return view('teacher.tests.mcq');
    }

    public function storeTest(Request $request){
        // Validate the request
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string|max:500',
        //     'file' => 'required|file|max:10240', // Example: max 10MB file size
        // ]);
        $file = $request->file('thumbnail');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('thumbnails', $fileName);
        // return $request;
        // return $filePath;
        Test::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'test_type'=>$request->type,
            'thumbnail'=>$filepath
        ]);
        return redirect()->back()->with('success', 'Test created successfully!');
    }

    public function createTest(){
        return view('teacher.tests.create.page');
    }

    public function customizeTest(string $id){
        // $test = Test::find($id);
        // $questions = Question::where('test_id', $id)->get();

        $result = Test::where('tests.id', $id)
                        ->join('questions', 'tests.id', '=', 'questions.test_id')
                        ->join('options', 'questions.answer', '=', 'options.id')
                        ->select(
                            'options.option as correct_option',
                            'questions.question as question_text',
                            'tests.id as test_id',
                            'tests.title as test_title',
                            'tests.test_type as test_type',
                            'tests.description as test_desc',
                            'questions.id as question_id'
                        )
                        ->get();
        if (count($result)<=0) {
            $test = Test::find($id);
            return view('teacher.tests.customize.page', ['results'=>[$test]]);
            // $results = [$test];
            // return response()->json([
            //     'result'=>$results[0]->title,
            // ]);  
        }
        // return response()->json([
        //     'message'=>$result,
        // ]);

        return view('teacher.tests.customize.page', ['results'=>$result]);
    }
    public function updateTest(Request $request, string $id){
        $test = Test::find($id);
        $test->title = $request->title;
        $test->description = $request->description;
        $test->test_type = $request->type;
        if($test->thumbnail){
            // Delete previous image from the server
            Storage::delete($test->thumbnail);
        }
        // return $request->file('thumbnail');
        $imagePath = $request->file('thumbnail')->store('public/thumbnails');
        $test->thumbnail = $imagePath;
        $test->save();
        return redirect()->back()->with('success', 'Test Updated Successfully!');
    }
    public function storeMcqQuestion(Request $request) {
        // Validate the request
        // $request->validate([
        //     'test_id' => 'required|exists:tests,id',
        //     'question' => 'required|string|max:255',
        //     'options' => 'required|array|min:2',
        //     'options.*' => 'required|string|max:255',
        // ]);
        // return response()->json([
        //     'message'=>$request->test_id,
        // ]);

        // Create the question
        $question = Question::create([
            'test_id' => $request->test_id,
            'question' => $request->question,
            'answer' => $request->correctanswer,
        ]);
    
        // Loop through the options and create them
        $options = $request->option;
        foreach ($options as $option) {
            Option::create([
                'tests_id' => $request->test_id,
                'question_id' => $question->id,
                'option' => $option,
            ]);
        }
        return redirect()->route('teacher.test.customize', ['id'=>$request->test_id])->with('success', 'Question Created successfully!');
        // return response()->json([
        //     'message' => 'Question Created successfully!',
        // ]);
    }
    

    public function customizeMcq(Request $request, string $id){
        $question = Question::find(base64_decode($id));
        $options = Option::where('question_id', base64_decode($id))->get();
        return view('teacher.tests.customize.mcq', ['question'=>$question, 'options'=>$options]);
    }

    public function updateMcq(Request $request, string $id){
        $question = Question::find(base64_decode($id));
        $options = Option::where('question_id', base64_decode($id))->get();

        $request_option_length = count($request->option);
        $actual_option_length = count($options);
        // return response()->json([
        //     'res_length'=>$request_option_length,
        //     'res_lngth'=>$actual_option_length,
        //     'act_length'=>$request->option,
        // ]);

        // return redirect()->route('test.mcq.customize', ['id'=>$id])->with('success', $request->option[1]);
        
        $question->question = $request->question;
        $question->answer = $request->correctanswer;
        $question->save();

        $additional_length = $request_option_length - $actual_option_length;
        foreach ($options as $key=>$option) {
            $option->option = $request->option[$key];
            $option->save();
        }
        if($request_option_length - $actual_option_length >= 1){
            for($i=$actual_option_length; $i<$request_option_length; $i++){
                Option::create([
                    'tests_id' => $question->test_id,
                    'question_id' => $question->id,
                    'option' => $request->option[$i],
                ]);
            }
        }
        return redirect()->route('test.mcq.customize', ['id'=>$id])->with('success', 'Question Updated Successfully!');
    }

    public function showQuestion(string $id){
        $questions = Question::where('test_id', base64_decode($id))->get();
        // return $questions;
        $existUser = TestResult::where('test_id', base64_decode($id))->where('user_id', Auth::id())->first();
        if(!empty($existUser)){
            return redirect()->route('results.show', ['testId'=>$id]);
        }
        
        $user_id = Auth::id();
        $options = Option::where('tests_id', base64_decode($id))->get();
        return view('frontend.test.teststart', ['questions'=>$questions, 'options'=>$options, 'user_id'=>$user_id]);
    }

    public function storeUsreAnswer(Request $request){
        // return $request->selectedans;
        $questions = $request->question;
        $optionName = 'option'.$questions[0];

        foreach ($questions as $key => $question) {
            $optionName = 'option'.$question;
            TestResult::create([
                // ['test_id', 'question_id', 'selected_answer', 'correct_answer', 'user_id']
                'test_id' => $request->test_id,
                'user_id' => $request->user_id,
                'question_id' => $question,
                'selected_answer' => $request->$optionName,
            ]);
        }
        return redirect()->route('results.show', ['testId'=>base64_encode($request->test_id)]);
        // return response()->json([
        //     'message'=>'Answer submitted successfully!'
        // ]);
    }

    public function showTestDetails(string $id){
        $test = Test::find(base64_decode($id));
        return view('frontend.test.testdetails', ['test'=>$test]);
    }

    public function showTestResult(){
        // Fetch all test results with calculations
        $testResults = TestResult::join('questions', 'test_results.question_id', '=', 'questions.id')
            ->join('users', 'test_results.user_id', '=', 'users.id')
            ->join('tests', 'test_results.test_id', '=', 'tests.id')
            ->select('users.name as user_name', 'tests.title as test_title',
                DB::raw('SUM(test_results.selected_answer = questions.answer) as total_correct'),
                DB::raw('SUM(test_results.selected_answer != questions.answer) as total_wrong')
            )
            ->groupBy('users.name', 'tests.title')
            ->get();

        return view('teacher.tests.result.page', compact('testResults'));
    }

    public function deleteMcq($id){

        $result = Question::find(base64_decode($id));
        $testId = $result->test_id;
        $isDelete = $result->delete();
        return redirect()->route('teacher.test.customize', ['id'=>$testId]);
    }

}
