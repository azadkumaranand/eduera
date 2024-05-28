<?php

namespace App\Http\Controllers\Frontend\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use App\Models\Option;

class TestController extends Controller
{
    public function showQuestion($testId)
    {
        $test = Test::find($testId);
        $questions = Question::find($testId)->paginate(1, ['*'], 'question', $questionNumber);
        $options = Option::where('test_id', $testId)->get();
        
        if ($questions->isEmpty()) {
            return redirect()->route('test.submit', $testId);
        }
        
        return view('test.question', [
            'test' => $test,
            'question' => $questions->first(),
            'questionNumber' => $questionNumber,
            'totalQuestions' => $questions->total(),
        ]);
    }

    public function submitAnswer(Request $request, $testId, $questionNumber)
    {
        $validated = $request->validate([
            'answer' => 'required',
        ]);

        $question = Question::find($request->question_id);
        
        $answer = new Answer();
        $answer->test_id = $testId;
        $answer->question_id = $question->id;
        $answer->user_id = auth()->id();
        $answer->answer = $validated['answer'];
        $answer->save();

        return redirect()->route('test.question', [$testId, $questionNumber + 1]);
    }

    public function submitTest($testId)
    {
        // Handle the final test submission, grading, etc.
        return redirect()->route('home')->with('status', 'Test submitted successfully!');
    }
}
