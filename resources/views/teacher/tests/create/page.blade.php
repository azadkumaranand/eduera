@extends("teacher.layout")
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
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="test-container my-4">
    <h4 class="text-secondary">You are one step away to create a test</h4>
    <form action="{{route('teacher.test.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="my-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="title">
                </div>
            </div>
            <div class="col-md-6">
                <div class="my-3">
                    <label for="type" class="form-label">Choose Test Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="mcq">MCQ</option>
                        <option value="subjective">Subjective</option>
                        <option value="poll">Poll</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="my-3">
                    <label for="title" class="form-label">Description</label>
                    <textarea type="text" rows="5" class="form-control" name="description" id="title"></textarea>
                </div>
            </div>
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
        <button class="btn btn-dark">Create</button>
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

@endsection