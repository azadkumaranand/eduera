@extends('teacher.layout')

@section('content')
<h4 class="text-secondary">Customized Course</h4>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{route('courses.update', ['id'=>base64_encode($course->id)])}}" method="POST">
    <!-- Course Information -->
    @csrf
    <div class="course-info">
      <div class="row">
        <div class="col-md">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" value="{{$course->title}}" name="title">
          </div>
        </div>
        <div class="col-md">
          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" value="{{$course->price}}" name="price">
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <textarea rows="5" type="text" class="form-control" id="desc" name="description">{{$course->description}}</textarea>
      </div>
    </div>

    <!-- Save Course -->
    <button type="submit" class="btn btn-dark">Update</button>
</form>

<div class="chapter my-4">
    <h4 class="text-secondary">Customized Chapters</h4>
    @foreach ($chapters as $chapter)
        <div class="card d-flex justify-content-between shadow-lg">
            <div class="card-body">
            <h5 class="card-title">{{$chapter->title}}</h5>
            </div>
            <a class="btn btn-dark" href="{{route('chapter.customize', ['id'=>base64_encode($chapter->id)])}}">Customize</a>
        </div>
    @endforeach
</div>

{{-- Add chapter to the course --}}

<div class="container mt-4">
    <h5 class="text-secondary">Customize Course: {{ $course->title }}</h5>

    <!-- Add Chapter Form -->
    <form id="chapterForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Chapter Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">Video</label>
            <input type="file" class="form-control" id="video" name="video" accept="video/*" required>
        </div>
        <!-- Upload Progress -->
        <div class="progress mt-3" style="display: none;">
            <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
        </div>
        <!-- Uploaded Files Preview -->
        <div id="preview" class="mt-3"></div>
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <button type="submit" class="btn btn-primary">Add Chapter</button>
    </form>
</div>

@endsection

@section('addScript')
@viteReactRefresh
@vite('resources/js/app.jsx')
<script>
    document.getElementById('chapterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("chapters.store") }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                var progressBar = document.querySelector('.progress-bar');
                progressBar.style.width = percentComplete + '%';
                progressBar.innerText = Math.round(percentComplete) + '%';
            }
        });
    
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById('preview').innerHTML = `
                    <h3 class="text-secondary">Uploaded Chapter</h3>
                    <p><strong>Title:</strong> ${response.title}</p>
                    <p><strong>Description:</strong> ${response.description}</p>
                    <p><strong>Thumbnail:</strong> <img src="${response.thumbnail_url}" alt="Thumbnail" width="100"></p>
                    <p><strong>Video:</strong> <video width="320" height="240" controls>
                        <source src="${response.video_url}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video></p>
                `;
                document.getElementById('chapterForm').reset();
                document.querySelector('.progress').style.display = 'none';
            } else {
                alert('An error occurred!');
            }
        };
    
        xhr.onerror = function() {
            alert('An error occurred!');
        };
    
        xhr.send(formData);
        document.querySelector('.progress').style.display = 'block';
    });
    </script>

@endsection