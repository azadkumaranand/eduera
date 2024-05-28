<?php

namespace App\Http\Controllers;
use App\Models\Test;
use App\Models\Option;
use App\Models\Question;
use App\Models\TestResult;

use Illuminate\Http\Request;



class TestController extends Controller
{
    public function show(){
        $tests = Test::all();
        return view('teacher.tests.page', ['tests'=>$tests]);
    }

    public function showmcqpage(){
        return view('teacher.tests.mcq');
    }

    public function storeTest(Request $request){
        // return response()->json([
        //     'message'=>'your are going to store your test'
        // ]);
        Test::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'test_type'=>$request->type,
        ]);
        return redirect()->back();
    }

    public function createTest(){
        return view('teacher.tests.create.page');
    }

    public function customizeTest(string $id){
        $test = Test::find($id);
        $questions = Question::where('test_id', $id)->get();
        return view('teacher.tests.customize.page', ['test'=>$test, 'questions'=>$questions]);
    }
    public function updateTest(Request $request, string $id){
        $test = Test::find($id);
        $test->title = $request->title;
        $test->description = $request->description;
        $test->test_type = $request->type;
        $test->save();
        return redirect()->back();
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
        //     'act_length'=>$actual_option_length,
        // ]);

        // return redirect()->route('test.mcq.customize', ['id'=>$id])->with('success', $request->option[1]);
        
        $question->question = $request->question;
        $question->answer = $request->correctanswer;
        $question->save();

        $request_option_length = count($request->option);
        $actual_option_length = count($options);
        $additional_length = $request_option_length - $actual_option_length;
        foreach ($options as $key=>$option) {
            $option->option = $request->option[$key];
            $option->save();
        }
        if($request_option_length - $actual_option_length > 1){
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
        $options = Option::where('tests_id', base64_decode($id))->get();
        return view('frontend.test.teststart', ['questions'=>$questions, 'options'=>$options]);
    }

    public function storeUsreAnswer(Request $request){
        // return $request->selectedans;
        $selectanswers = $request->selectedans;
        $question = $request->question_id;
        $correctanswers = $request->correctans;
        // return response()->json([
        //     'cans'=>$correctanswers,
        //     'ans'=>$selectanswers,
        //     'qst'=>$question,
        // ]);
        foreach ($selectanswers as $key => $selectanswer) {
            TestResult::create([
                // ['test_id', 'question_id', 'selected_answer', 'correct_answer', 'user_id']
                'test_id' => $request->test_id,
                'user_id' => $request->user_id,
                'question_id' => $question[$key],
                'selected_answer' => $selectanswer,
                'correct_answer' => $correctanswers[$key],
            ]);
        }
        return response()->json([
            'message'=>'Answer submitted successfully!'
        ]);
    }

    public function showTestDetails(string $id){
        $test = Test::find(base64_decode($id));
        return view('frontend.test.testdetails', ['test'=>$test]);
    }

}
