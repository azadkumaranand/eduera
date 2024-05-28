@extends("teacher.layout")

@section('content')
<div class="test-container my-4">
    <h4 class="text-secondary">You are one step away to create a test</h4>
    <form action="{{route('teacher.test.create')}}" method="POST">
        @csrf
        <div class="my-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title">
        </div>
        <div class="my-3">
            <label for="title" class="form-label">Description</label>
            <textarea type="text" rows="5" class="form-control" name="description" id="title"></textarea>
        </div>
        <div class="my-3">
            <label for="type" class="form-label">Choose Test Type</label>
            <select name="type" id="type" class="form-control">
                <option value="mcq">MCQ</option>
                <option value="subjective">Subjective</option>
                <option value="poll">Poll</option>
            </select>
        </div>
        <button class="btn btn-dark">Create</button>
    </form>
    
</div>
@endsection