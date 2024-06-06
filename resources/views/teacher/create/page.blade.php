@extends('teacher.layout')

@section('title')
Create Course 
@endsection

@section('addStyle')
<style>
    .image-layer{
        background-color: rgba(97, 97, 97, 0.7);
        cursor: pointer;
        opacity: 0;
    }
    .img-box{
        border: 4px dashed rgb(22, 35, 46);
    }
</style>
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
    <form action="{{route('courses.store')}}" method="POST" enctype="multipart/form-data">
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
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="desc" class="form-label">Description</label>
                <textarea type="text" class="form-control" id="desc" name="description"></textarea>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="col-md-6">
                <div class="col-lg-6 d-flex justify-content-center flex-column">
                    <div class="text-secondary">Thumbnail</div>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" style="display: none;">
                    <label for="thumbnail">
                        <div class="position-relative image-container" style="width: 300px; height: 300px">
                            <div class="image-layer position-absolute d-none justify-content-center align-item-center h-100 w-100 z-1">
                                <h6 class="m-auto text-primary">Browse</h6>
                            </div>
                            <div class="img-box d-flex justify-content-center h-100 w-100 align-items-center">
                                <i class="fa fa-camera" style="font-size: 25px;"></i>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            </div>
          </div>
          
        </div>

        {{-- <!-- Chapters Management (React Component) -->
        <div id="chapters-management"></div> --}}

        <!-- Save Course -->
        <button type="submit" class="btn btn-dark">Save Course</button>
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
            let image = document.createElement('img');
            image.src = event.target.result;
            image.style.width = '300px';
            image.style.height = '300px';
            document.querySelector('.img-box').innerHTML = '';
            document.querySelector('.img-box').appendChild(image);
        };
        
        reader.readAsDataURL(file);
    });

    //thumbnail image browse
    courseThumbnail.addEventListener('mouseover', ()=>{
        imageLayer.style.opacity = '1';
    })
    courseThumbnail.addEventListener('mouseout', ()=>{
        imageLayer.style.opacity = '0';
    })


</script>

<script src="https://cdn.tiny.cloud/1/a3scpssrw8e2i5ghmjy1nogccku0l93o7c1oqugurh9idzsq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
    tinymce.init({
    selector: '#desc',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
    toolbar_mode: 'floating',
    });
</script>

@endsection