@extends('frontend.layouts.layout')

@section('content')

    <div class="container">
        <div class="thumbnail-box">
            <div class="thumbnail">
                <img class="img-fluid w-100" src="/assets/img/course-1.jpg" alt="">
            </div>
            <div class="content-box">
                <div class="course-title fs-4 mt-4 mb-3 text-secondary">
                    {{$course->title}} <a href="#" class="text-primary fs-5 ms-2">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
                <div class="course-description">
                    {{$course->description}}
                </div>
                <div class="mt-4 fs-6" style="width: 50rem;">
                    <div class="card-header">
                      Key Concept Covered
                    </div>
                    <ul class="list-group list-group-flush border-end-0">
                        @foreach ($chapters as $chapter)
                            <li class="list-group-item">{{$chapter->title}}</li>
                        @endforeach
                    </ul>
                  </div>
            </div>
        </div>
    </div>

@endsection