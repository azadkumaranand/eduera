@extends('frontend.layouts.layout')

@section('content')

<div class="test-container">
    {{-- <form action="{{route('test.submit')}}" method="POST"> --}}
        <div class="test-form" id="test-form" data-user-id="{{Auth::id()}}" data-question="{{$questions}}" data-submit-url="{{route('test.submit')}}" data-option="{{$options}}" data-csrf="{{ csrf_token() }}">

        </div>
    {{-- </form> --}}
</div>

@endsection