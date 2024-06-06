@extends('frontend.layouts.layout') {{-- Assume you have a main layout file --}}

@section('addStyle')
<style>
    /* .container { margin-top: 20px; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px; } */
    .chart-container {
        width: 200px;
        height: 200px;
        margin: auto;  // Center the canvas element
    }
    .option-label { cursor: pointer; padding: 10px; display: inline-block; }
    input[type="radio"] { display: none; }
    input[type="radio"]:checked + label {
        background-color: green;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="d-flex my-3">
        <h4 class="me-2">Test Results for </h4> {!! $testId !!}
    </div>
    <div class="chart-container">
        <canvas id="resultsChart"></canvas>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Question</th>
                <th>Your Answer</th>
                <th>Correct Answer</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result['question'] }}</td>
                    <td>{{ $result['selected_ans'] }}</td>
                    <td>{{ $result['correct_ans'] }}</td>
                    <td>{{ $result['is_correct'] ? 'Correct' : 'Incorrect' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('addScript')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('resultsChart').getContext('2d');
    const correctCount = @json($correctCount);
    const incorrectCount = @json($incorrectCount);
    const resultsChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Correct', 'Incorrect'],
            datasets: [{
                label: 'Test Result',
                data: [correctCount, incorrectCount],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Maintain the aspect ratio of the canvas
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                },
            }
        }
    });
});
</script>
@endsection

