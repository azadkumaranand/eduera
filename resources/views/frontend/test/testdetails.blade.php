@extends('frontend.layouts.layout')

@section('content')

<div class="contianer d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card text-center p-4">
        <p>{!!$test->title!!}</p>
        <div>{!! $test->description !!}</div>
        <div class="card-footer">
            <a href="{{route('test.start', ['id'=>base64_encode($test->id)])}}">
                <button class="btn btn-primary">
                    Start Test
                </button>
            </a>
        </div>
    </div>
</div>

@endsection