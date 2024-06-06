<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <title>Test</title>
    <style>
        .container { margin-top: 20px; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px; }
        .option-label { cursor: pointer; }
        input[type="radio"] { display: none; }  /* Hide radio buttons */
        input[type="radio"]:checked + label {
            background-color: green; /* Change background color when selected */
            color: white;
        }
        
        .question-container{
                width: 50%;
            }
        @media(max-width: 992px){
            .question-container{
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="test-form" id="test-form">
            <div class="container">
                <div id="timer" class="position-fixed end-0 top-1 bg-warning py-3 px-4 rounded-2 text-light h3"></div>
                <form id="testForm" action="{{route('test.submit')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user_id}}">
                    <input type="hidden" name="test_id" value="{{$questions[0]->test_id}}">
                    @foreach ($questions as $index => $question)
                    <div class="question-container m-auto">
                        <p>Q{{ $index + 1 }}. {{ $question['question'] }}</p>
                        <input type="hidden" name="question[]" value="{{$question->id}}">
                        <ul style="list-style: none">
                            @foreach ($options as $option)
                                @if ($option['question_id'] == $question['id'])
                                    <li>
                                        <input type="radio" id="option-{{ $question['id'] }}-{{ $option['id'] }}" name="option{{ $question['id'] }}" value="{{ $option['id'] }}" onchange="optionChange({{ $question['id'] }}, {{ $option['id'] }})">
                                        <label class="border border-2 p-2 rounded-2 my-1 text-wrap option-label w-100 text-start" for="option-{{ $question['id'] }}-{{ $option['id'] }}">
                                            {{ $option['option'] }}
                                        </label>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                    <div class="question-container m-auto text-end">
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let selectedOptions = [];
        let timeLeft = parseInt(localStorage.getItem('timeLeft')) || 1800; // 30 minutes as default
    
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('timer').textContent = `Timer: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }
    
        function optionChange(questionId, optionId) {
            // Update the selectedOptions array
            const existingIndex = selectedOptions.findIndex(opt => opt.question_id === questionId);
            if (existingIndex >= 0) {
                selectedOptions[existingIndex].selectanswer = optionId;
            } else {
                selectedOptions.push({ question_id: questionId, selectanswer: optionId });
            }
        }
    
        function handleSubmit(event) {
            event.preventDefault();
            console.log("submitting", selectedOptions);
            // Add Fetch API implementation if required here
        }
    
        document.addEventListener('DOMContentLoaded', function () {
            const timer = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    handleSubmit(new Event('submit')); // Auto-submit when time runs out
                } else {
                    timeLeft--;
                    updateTimer();
                }
            }, 1000);
    
            updateTimer();
        });
    </script>
</body>
</html>

