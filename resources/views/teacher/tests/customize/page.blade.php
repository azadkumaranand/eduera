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
    <div class="test-container my-4">
        <h4 class="text-secondary">Customize Your Test</h4>
        @if (count($results) > 1)
            <form action="{{ route('teacher.test.update', ['id' => $results[0]->test_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="my-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                value="{{ $results[0]->test_title }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="my-3">
                            <label for="type" class="form-label">Choose Test Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="mcq" @if ($results[0]->test_type == 'mcq') selected @endif>MCQ</option>
                                <option value="subjective" @if ($results[0]->test_type == 'subjective') selected @endif>Subjective
                                </option>
                                <option value="poll" @if ($results[0]->test_type == 'poll') selected @endif>Poll</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="my-3">
                            <label for="title" class="form-label">Description</label>
                            <textarea type="text" rows="5" class="form-control" name="description" id="title">{{ $results[0]->test_desc }}</textarea>
                        </div>
                    </div>
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
                                        <i class="fa fa-camera" style="font-size: 25px;"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-dark">Update</button>
            </form>
        @else
            <form action="{{ route('teacher.test.update', ['id' => $results[0]->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="my-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                value="{{ $results[0]->title }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="my-3">
                            <label for="type" class="form-label">Choose Test Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="mcq" @if ($results[0]->test_type == 'mcq') selected @endif>MCQ</option>
                                <option value="subjective" @if ($results[0]->test_type == 'subjective') selected @endif>Subjective
                                </option>
                                <option value="poll" @if ($results[0]->test_type == 'poll') selected @endif>Poll</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="my-3">
                            <label for="title" class="form-label">Description</label>
                            <textarea type="text" rows="5" class="form-control" name="description" id="title">{{ $results[0]->description }}</textarea>
                        </div>
                    </div>
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
                                        @if (!empty($results[0]->thumbnail))
                                            <img src="{{Storage::url($results[0]->thumbnail)}}" alt="thumbnail" style="width: 300px; height: 300px">
                                        @else
                                            <i class="fa fa-camera" style="font-size: 25px;"></i>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-dark">Update</button>
            </form>
        @endif

        {{-- <div class="my-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ $results[0]->test_title }}">
            </div>
            <div class="my-3">
                <label for="title" class="form-label">Description</label>
                <textarea type="text" rows="5" class="form-control" name="description" id="title">{{ $results[0]->test_desc }}</textarea>
            </div>
            <div class="my-3">
                <label for="type" class="form-label">Choose Test Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="mcq" @if ($results[0]->test_type == 'mcq') selected @endif>MCQ</option>
                    <option value="subjective" @if ($results[0]->test_type == 'subjective') selected @endif>Subjective</option>
                    <option value="poll" @if ($results[0]->test_type == 'poll') selected @endif>Poll</option>
                </select>
            </div> --}}

        <div class="questions-container">
            <div class="chapter my-4 position-relative">
                <button type="button" class="btn btn-dark position-absolute end-0 top-2" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    + Add Question
                </button>
                <h4 class="text-secondary">Customize Test</h4>
                <div class="row">
                    @if (count($results) > 1)
                        @foreach ($results as $key => $result)
                            <div class="card col-lg-6 g-3 d-flex justify-content-between shadow-lg">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $key + 1 . ')' }}{{ $result->question_text }}</h6>
                                    <p>Ans: {{ $result->correct_option }}</p>
                                </div>
                                <a class="btn btn-dark"
                                    href="{{ route('test.mcq.customize', ['id' => base64_encode($result->question_id)]) }}">Customize</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- question adding form --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-secondary">Create MCQ Questions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="question-container my-3">
                        @if ($results[0]->test_type == 'mcq')
                            <form action="{{ route('teacher.test.mcq.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="test_id" value="{{ $results[0]->test_id }}">
                                <div class="mcq-question-container">
                                    <div class="my-3">
                                        <label for="question" class="form-label">Question</label>
                                        <input type="text" id="question" class="form-control" name="question">
                                    </div>
                                    <div class="option-container">
                                        <div class="my-3">
                                            <label for="option1" class="form-label">Option 1</label>
                                            <input type="text" id="option1" class="form-control" name="option[]">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <p class="btn btn-dark mt-2" id="add-option">
                                            Add Option
                                        </p>
                                    </div>
                                    <div class="correct-ans my-3">
                                        <select id="correct-answer" class="form-select" name="correctanswer">
                                            <option selected>Select the correct answer</option>
                                        </select>
                                    </div>
                                    <div class="submit-btn">
                                        <button class="btn btn-dark">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- question adding form end --}}
@endsection


@section('addScript')
    <script>
        const addOption = document.getElementById('add-option');
        const optionContainer = document.querySelector('.option-container');
        const correctAnswerSelect = document.getElementById('correct-answer');
        let optioncount = 1;

        function updateSelectOption() {
            // Add an option to the select element for the correct answer
            let selectOption = document.createElement('option');
            selectOption.value = optioncount;
            selectOption.textContent = `Option ${optioncount}`;
            correctAnswerSelect.appendChild(selectOption);
            let optionhandle = document.getElementById(`option${optioncount}`)
            optionhandle.addEventListener('change', () => {
                selectOption.textContent = optionhandle.value ? `${optionhandle.value}` : `Option ${optioncount}`;
                selectOption.value = optionhandle.value;
            })
        }

        addOption.addEventListener('click', () => {
            optioncount++;
            let option = `<div class="my-3">
                            <label for="question" class="form-label">Option ${optioncount}</label>
                            <input id='option${optioncount}' type="text" class="form-control" name="option[]">
                        </div>`;
            optionContainer.insertAdjacentHTML('beforeend', option);
            updateSelectOption();
        })
        // updateSelectOption();

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
