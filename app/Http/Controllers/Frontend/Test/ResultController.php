<?php

namespace App\Http\Controllers\Frontend\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TestResult;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Support\Facades\DB;
use Auth;

class ResultController extends Controller
{
    public function showResults(string $testId)
    {
        $test = Test::find(base64_decode($testId));

        $results = TestResult::where('user_id', Auth::id())
                                ->where('test_results.test_id', base64_decode($testId))
                                ->join('questions', 'test_results.question_id', '=', 'questions.id')
                                ->leftjoin('options as correct_options', 'questions.answer', '=', 'correct_options.id')
                                ->leftjoin('options as selected_options', 'test_results.selected_answer', '=', 'selected_options.id')
                                ->select('questions.question as question', 'correct_options.option as correct_ans', 'selected_options.option as selected_ans',
                                    DB::raw('IFNULL(test_results.selected_answer, 0) = questions.answer as is_correct')
                                )
                                ->get();

        $correctCount = $results->where('is_correct', true)->count();
        $incorrectCount = $results->where('is_correct', false)->count();

        $resultsWithQuestions = $results->map(function($result){
            return [
                'question' => $result->question,
                'selected_answer' => $result->selected_ans,
                'correct_answer' => $result->correct_ans,
                'is_correct' => $result->is_correct,
            ];
        });

        // return response()->json([
        //     'message'=>$results,
        // ]);
        // Fetch all test results for this user and test
        // $results = TestResult::where('user_id', Auth::id())
        //                      ->where('test_id', base64_decode($testId))
        //                      ->get();

        // Fetch all questions for this test
        // $questions = Question::where('test_id', base64_decode($testId))->get();

        // Pass these to the view
        return view('frontend.test.result.show', [
            'results' => $resultsWithQuestions,
            'correctCount' => $correctCount,
            'incorrectCount' => $incorrectCount,
            'testId' => $test->title
        ]);
        
    }
}
