@extends('teacher.layout')

@section('addStyle')
    <style>
        .image-layer {
            background-color: rgba(97, 97, 97, 0.7);
            cursor: pointer;
            opacity: 0;
        }

        .img-box {
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
    <form action="{{ route('courses.update', ['id' => base64_encode($course->id)]) }}" method="POST"
        enctype="multipart/form-data">
        <!-- Course Information -->
        @csrf
        <div class="course-info">
            <div class="row">
                <div class="col-md">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" value="{{ $course->title }}"
                            name="title">
                    </div>
                </div>
                <div class="col-md">
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" value="{{ $course->price }}"
                            name="price">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="coursedesc" class="form-label">Description</label>
                        <textarea type="text" rows="10" class="form-control" id="coursedesc" name="description">{{ $course->description }}</textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="col-md-6">
                        <div class="col-lg-6 d-flex justify-content-center flex-column">
                            <div class="text-secondary">Thumbnail</div>
                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" style="display: none;">
                            <label for="thumbnail">
                                <div class="position-relative image-container" style="width: 300px; height: 300px">
                                    <div
                                        class="image-layer position-absolute d-none justify-content-center align-item-center h-100 w-100 z-1">
                                        <h6 class="m-auto text-primary">Browse</h6>
                                    </div>
                                    <div class="img-box d-flex justify-content-center h-100 w-100 align-items-center">
                                        @if (!empty($course->thumbnail))
                                            <img src="{{ Storage::url($course->thumbnail) }}" alt="thumbnail"
                                                style="width: 300px; height: 300px">
                                        @else
                                            <i class="fa fa-camera" style="font-size: 25px;"></i>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="draft" @if ($course->status == 'draft') selected @endif>Draft</option>
                    <option value="publish" @if ($course->status == 'publish') selected @endif>Publish</option>
                </select>
            </div>
        </div>

        <!-- Save Course -->
        <button type="submit" class="btn btn-dark">Update</button>
    </form>

    <div class="chapter my-4">
        <div class="add-chapter position-relative my-3 py-3">
            <button type="button" class="btn btn-dark position-absolute end-0 z-1" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                +Add Chapter
            </button>
        </div>
        <h4 class="text-secondary">Customized Chapters</h4>
        @foreach ($chapters as $chapter)
            <div class="card d-flex justify-content-between shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">{{ $chapter->title }}</h5>
                </div>
                <a class="btn btn-dark"
                    href="{{ route('chapter.customize', ['id' => base64_encode($chapter->id)]) }}">Customize</a>
            </div>
        @endforeach
    </div>

    {{-- Add chapter to the course --}}
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-secondary">Fill chapter details.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container mt-4">
                        <!-- Add Chapter Form -->
                        <form action="{{ route('chapters.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Chapter Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="chapterdesc" name="description"></textarea>
                            </div>
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button type="submit" class="btn btn-dark">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
        courseThumbnail.addEventListener('mouseover', () => {
            imageLayer.style.opacity = '1';
        })
        courseThumbnail.addEventListener('mouseout', () => {
            imageLayer.style.opacity = '0';
        })
    </script>

<script src="https://cdn.tiny.cloud/1/a3scpssrw8e2i5ghmjy1nogccku0l93o7c1oqugurh9idzsq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
    tinymce.init({
    selector: '#coursedesc',
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
