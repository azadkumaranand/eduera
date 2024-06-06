@extends('teacher.layout')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Students' Test Results</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Test ID</th>
                <th>Total Correct Answers</th>
                <th>Total Wrong Answers</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($testResults as $result)
                <tr>
                    <td>{{ $result->user_name }}</td>
                    <td>{!! $result->test_title !!}</td>
                    <td>{{ $result->total_correct }}</td>
                    <td>{{ $result->total_wrong }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection