@extends('teacher.layout')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a class="" href="{{ route('teacher.test.customize', ['id' => $question->test_id]) }}">Go Back</a>
    <form id="updateform" action="{{ route('test.mcq.update', ['id' => base64_encode($question->id)]) }}" method="POST">
        @csrf
        <div class="my-2">
            <label for="question" class="form-label">Question</label>
            <input type="text" class="form-control" name="question" value='{{ $question->question }}' />
        </div>
        <div class="option-container">
            @foreach ($options as $key => $option)
                <div class="my-2">
                    <label class="form-label">Option {{ $key + 1 }}</label>
                    <input type="text" class="form-control" id="option{{ $key + 1 }}" name="option[]"
                        value='{{ $option->option }}' />
                </div>
            @endforeach
        </div>
        {{-- <div class="additonal-option" id="add-option" data-q-id="{{ $question->id }}"
            data-test-id="{{ $question->test_id }}">

        </div> --}}
        <div className="my-2">
            <label htmlFor="correct-answer" className="form-label">
                Choose Correct answer
            </label>
            <select name="correctanswer" id="correct-answer" class="form-control">
                @foreach ($options as $key => $option)
                    <option value="{{ $option->id }}" @if ($question->answer == $option->id) selected @endif>
                        {{ $option->option }}</option>
                @endforeach
            </select>
        </div>
    </form>
    <div class="d-sm-flex align-items-center">
        <button type="submit" onclick="document.querySelector('#updateform').submit()"
            class="btn btn-dark my-2 me-2">Update</button>
        <a href="{{ route('test.mcq.delete', ['id' => base64_encode($question->id)]) }}" class="me-2">
            <button class="btn btn-danger">Delete</button>
        </a>
        <button class="btn btn-dark" id="add-option">Add Option</button>
    </div>
@endsection

@section('addScript')
    <script>
        const addOptionButton = document.getElementById('add-option');
        const optionContainer = document.querySelector('.option-container');
        const correctAnswerSelect = document.getElementById('correct-answer');
        let optionCount = @json(count($options));

        function updateSelectOption(optionId) {
            // Add an option to the select element for the correct answer
            let selectOption = document.createElement('option');
            selectOption.value = optionId;
            selectOption.textContent = `Option ${optionId}`;
            correctAnswerSelect.appendChild(selectOption);

            let optionHandle = document.getElementById(`option${optionId}`);
            optionHandle.addEventListener('change', () => {
                selectOption.textContent = optionHandle.value ? optionHandle.value : `Option ${optionId}`;
                selectOption.value = optionhandle.value;
            });
        }

        function addOptionElement(optionId) {
            let option = `
            <div class="my-3" id="option-div-${optionId}">
                <label for="question" class="form-label">Option ${optionId}</label>
                <span class="badge bg-danger ms-2" style="cursor:pointer" onclick="removeOption(${optionId})">Remove</span>
                <input id="option${optionId}" type="text" class="form-control" name="option[]">
            </div>`;
            optionContainer.insertAdjacentHTML('beforeend', option);
            updateSelectOption(optionId);
        }

        function removeOption(optionId) {
            // Remove the option input
            const optionDiv = document.getElementById(`option-div-${optionId}`);
            if (optionDiv) {
                optionDiv.remove();
            }
            // Remove the corresponding option from the select element
            const selectOption = correctAnswerSelect.querySelector(`option[value="${optionId}"]`);
            if (selectOption) {
                selectOption.remove();
            }
        }

        addOptionButton.addEventListener('click', (e) => {
            e.preventDefault();
            optionCount++;
            addOptionElement(optionCount);
        });
    </script>
@endsection
