@extends('teacher.layout')

@section('addStyle')
<style>
    .video-layer, .image-layer{
        background-color: rgba(97, 97, 97, 0.7);
        cursor: pointer;
        opacity: 0;
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

@if (session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
@endif
    
<div class="container mt-4">
    <a href="{{route('courses.customize', ['id'=>base64_encode($chapter[0]->course_id)])}}">Go Back</a>
    <h5 class="text-secondary">Customize Chapter</h5>

    <!-- Add Chapter Form -->
    <form action="{{route('chapter.update', ['id'=>$chapter[0]->chapter_id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Chapter Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$chapter[0]->chapter_title}}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea rows="10" class="form-control" id="chapterdesc" name="description">{{$chapter[0]->chapter_desc}}</textarea>
        </div>

        <button type="submit" class="btn btn-dark update_btn">Update</button>
    </form>
</div>


{{-- Added Content --}}
<h4 class="text-center text-secondary">Available Contents</h4>

<div class="container">
    <div class="add-chapter position-relative my-3 py-3">
        <button type="button" class="btn btn-dark position-absolute end-0 z-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
            +Add Content
          </button>
    </div>
    <h4 class="text-secondary">Customized Content</h4>
    @if (!isset($chapter[0]->content_id))
        <p class="text-secondary text-center">No content available</p>
    @else
        @foreach ($chapter as $key=>$content)
            <div class="card d-flex justify-content-between shadow-lg my-3">
                <div class="card-body">
                <h5 class="card-title">{{$content->content_title}}</h5>
                </div>
                <a class="btn btn-dark" href="{{route('content.customize', ['id'=>base64_encode($content->content_id)])}}">Customize</a>
            </div>
        @endforeach
    @endif
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="text-secondary mt-5">Fill Content Details.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container mt-4">
                <form action="{{route('chapter.content.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapter[0]->chapter_id }}">
                    <div class="form-group my-2">
                        <label for="title">Content Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="body">Content Body</label>
                        <textarea name="body" id="richTextEditor" class="form-control"></textarea>
                    </div>
                    <div class="form-group my-2">
                        <label for="order">Content Order</label>
                        <input type="text" name="content_order" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-dark">Create</button>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>

{{-- code editor --}}

@endsection

@section('addScript')

<!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/a3scpssrw8e2i5ghmjy1nogccku0l93o7c1oqugurh9idzsq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
      tinymce.init({
        selector: '#richTextEditor',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        toolbar_mode: 'floating',
      });
      tinymce.init({
        selector: '#chapterdesc',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        toolbar_mode: 'floating',
      });
    </script>

@endsection