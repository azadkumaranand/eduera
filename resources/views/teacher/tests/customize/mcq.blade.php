@extends('teacher.layout')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a class="" href="{{route('teacher.test.customize', ['id'=>$question->test_id])}}">Go Back</a>
    <form action="{{ route('test.mcq.update', ['id' => base64_encode($question->id)]) }}" method="POST">
        @csrf
        <div class="my-2">
            <label for="question" class="form-label">Question</label>
            <input type="text" class="form-control" name="question" value='{{ $question->question }}' />
        </div>

        @foreach ($options as $key => $option)
            <div class="my-2">
                <label class="form-label">Option {{ $key + 1 }}</label>
                <input type="text" class="form-control" name="option[]" value='{{ $option->option }}' />
            </div>
        @endforeach
        <div class="additonal-option" id="add-option" data-q-id="{{ $question->id }}"
            data-test-id="{{ $question->test_id }}">

        </div>
        <div className="my-2">
            <label htmlFor="correctanswer" className="form-label">
                Choose Correct answer
            </label>
            <select name="correctanswer" id="correctanswer" class="form-control">
                @foreach ($options as $key=>$option)
                    <option value="{{$option->id}}">{{$option->option}}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-dark my-2">Update</button>
    </form>
@endsection
