@extends('teacher.layout')

@section('title')
Create Course 
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <h2>Create Course</h2>
    <form action="{{route('courses.store')}}" method="POST">
        <!-- Course Information -->
        @csrf
        <div class="course-info">
          <div class="row">
            <div class="col-md">
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title">
              </div>
            </div>
            <div class="col-md">
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="desc" class="form-label">Description</label>
            <textarea type="text" class="form-control" id="desc" name="description"></textarea>
          </div>
        </div>

        {{-- <!-- Chapters Management (React Component) -->
        <div id="chapters-management"></div> --}}

        <!-- Save Course -->
        <button type="submit" class="btn btn-dark">Save Course</button>
    </form>
</div>
@endsection