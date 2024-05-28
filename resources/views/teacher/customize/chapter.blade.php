@extends('teacher.layout')

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

@section('addStyle')
<style>
    .video-layer, .image-layer{
        background-color: rgba(97, 97, 97, 0.7);
        cursor: pointer;
        opacity: 0;
    }
</style>
@endsection

<div class="container mt-4">
    <h5 class="text-secondary">Customize Chapter: {{ $chapter->title }}</h5>

    <!-- Add Chapter Form -->
    <form id="chapterForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Chapter Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$chapter->title}}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{$chapter->description}}</textarea>
        </div>

        <div class="row">
            <!-- HTML -->
            <div class="col-lg-6 d-flex justify-content-center">
                <label for="video" id="file-label" class="position-relative">
                    <div class="text-secondary">Lecture</div>
                    <div class="position-relative video-container">
                        <div class="video-layer position-absolute d-flex justify-content-center align-item-center h-100 w-100 z-1">
                            <h6 class="m-auto text-primary">Browse</h6>
                        </div>
                        <video id="course-video" class="video-js vjs-default-skin" preload="auto" width="300" height="300" data-setup='{}'>
                            <source src="{{ Storage::url($attachment->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>  
                    </div>             
                </label>
                <input type="file" class="form-control"  id="video" name="video" accept="video/*" style="display: none">
            </div>

            <div class="col-lg-6 d-flex justify-content-center">
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*" style="display: none;">
                <label for="thumbnail">
                    <div class="text-secondary">Thumbnail</div>
                    <div class="position-relative image-container">
                        <div class="image-layer position-absolute d-flex justify-content-center align-item-center h-100 w-100 z-1">
                            <h6 class="m-auto text-primary">Browse</h6>
                        </div>
                        <img id="image-preview" class="" style="width: 300px; height: 300px" src="{{Storage::url($attachment->thumbnail)}}" alt="Image Preview">
                    </div>
                </label>
            </div>

        </div>
        
        <!-- Upload Progress -->
        <div class="progress mt-3" style="display: none;">
            <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
        </div>
        <!-- Uploaded Files Preview -->
        <div id="preview" class="mt-3"></div>
        {{-- <input type="hidden" name="course_id" value="{{ $course->id }}"> --}}
        <button type="submit" class="btn btn-dark update_btn">Update</button>
    </form>
</div>

@endsection

@section('addScript')

<script>
    // thumbnail input change
    document.getElementById('thumbnail').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(event) {
            document.getElementById('image-preview').src = event.target.result;
        };
        
        reader.readAsDataURL(file);
    });

    ////video lecture browse
    const courseVideo = document.querySelector('.video-container');
    const courseThumbnail = document.querySelector('.image-container');
    const videoLayer = document.querySelector('.video-layer');
    const imageLayer = document.querySelector('.image-layer');
    courseVideo.addEventListener('mouseover', ()=>{
        videoLayer.style.opacity = '1';
    })
    courseVideo.addEventListener('mouseout', ()=>{
        videoLayer.style.opacity = '0';
    })
    //thumbnail image browse
    courseThumbnail.addEventListener('mouseover', ()=>{
        imageLayer.style.opacity = '1';
    })
    courseThumbnail.addEventListener('mouseout', ()=>{
        imageLayer.style.opacity = '0';
    })
    //handle chapter update ajax
    document.getElementById('chapterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let updateBtn = document.querySelector('.update_btn');
        updateBtn.disabled = true;
        var formData = new FormData(this);
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("courses.update", ['id'=>$chapter->id]) }}', true);
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
                document.getElementById('preview').innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">${response.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                `;
                // document.getElementById('chapterForm').reset();
                updateBtn.disabled = false;
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