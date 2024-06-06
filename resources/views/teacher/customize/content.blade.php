@extends('teacher.layout')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif
<a href="{{route('chapter.customize', ['id'=>base64_encode($content->chapter_id)])}}">Go Back</a>
<div class="container mt-4">
    <form action="{{route('content.update')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="content_id" value="{{ $content->id }}">
        <div class="form-group my-2">
            <label for="title" class="form-label">Content Title</label>
            <input type="text" name="title" class="form-control" value="{{$content->title}}" required>
        </div>
        <div class="form-group my-2">
            <label for="body" class="form-label">Content Body</label>
            <textarea name="body" id="richTextEditor" class="form-control">{{$content->body}}</textarea>
        </div>
        <div class="form-group my-2">
            <label for="order" class="form-label">Content Order</label>
            <input type="text" name="content_order" class="form-control" value="{{$content->content_order}}">
        </div>
        <div class="d-flex justify-content-start align-items-center mt-3">
            <button type="submit" class="btn btn-dark me-2">Update</button>
            <a href="{{route('content.delete', ['id'=>base64_encode($content->id)])}}" class="btn btn-danger">
                Delete
            </a>
        </div>
    </form>
</div>

@endsection

@section('addScript')

<script src="https://cdn.tiny.cloud/1/a3scpssrw8e2i5ghmjy1nogccku0l93o7c1oqugurh9idzsq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
    tinymce.init({
    selector: '#richTextEditor',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
    toolbar_mode: 'floating',
    });
</script>


@endsection