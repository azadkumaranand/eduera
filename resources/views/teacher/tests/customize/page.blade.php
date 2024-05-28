@extends("teacher.layout")

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="test-container my-4">
    <h4 class="text-secondary">Customize Your Test</h4>
    <form action="{{route('teacher.test.update', ['id'=>$test->id])}}" method="POST">
        @csrf
        <div class="my-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{$test->title}}">
        </div>
        <div class="my-3">
            <label for="title" class="form-label">Description</label>
            <textarea type="text" rows="5" class="form-control" name="description" id="title">{{$test->description}}</textarea>
        </div>
        <div class="my-3">
            <label for="type" class="form-label">Choose Test Type</label>
            <select name="type" id="type" class="form-control">
                <option value="mcq" @if($test->test_type == 'mcq') selected @endif>MCQ</option>
                <option value="subjective" @if($test->test_type == 'subjective') selected @endif>Subjective</option>
                <option value="poll" @if($test->test_type == 'poll') selected @endif>Poll</option>
            </select>
        </div>
        <button class="btn btn-dark">Update</button>
    </form>

    <div class="questions-container">
        <div class="chapter my-4">
            <h4 class="text-secondary">Customize Test</h4>
            <div class="row">
            @foreach ($questions as $key=>$question)
                <div class="card col-lg-6 g-3 d-flex justify-content-between shadow-lg">
                    <div class="card-body">
                    <h5 class="card-title">{{($key+1).')'}}{{$question->question}}</h5>
                    </div>
                    <a class="btn btn-dark" href="{{route('test.mcq.customize', ['id'=>base64_encode($question->id)])}}">Customize</a>
                </div>
            @endforeach
        </div>
        </div>
    </div>

    <div class="question-container my-3">
        @if ($test->test_type == 'mcq')
            <h4 class="text-secondary">Create MCQ Questions</h4>
            <form action="{{route('teacher.test.mcq.store')}}" method="POST">
                @csrf
                <input type="hidden" name="test_id" value="{{$test->id}}">
                <div class="mcq-question-container">
                    
                </div>
            </form>
        @endif
    </div>
</div>
@endsection