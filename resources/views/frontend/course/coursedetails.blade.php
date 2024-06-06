@extends('frontend.layouts.layout')

@section('content')

    <div class="container py-3 my-3">
        <div class="thumbnail-box">
            <div class="row">
                <div class="col-lg-6">
                    <div class="thumbnail">
                        @if ($course->thumbnail)
                            <img class="img-fluid w-100" src="{{Storage::url($course->thumbnail)}}" alt="">
                        @else
                            <img class="img-fluid w-100" src="/assets/img/course-1.jpg" alt="">
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="course-title fs-4 mt-4 mb-3 text-secondary">
                        {{$course->title}} 
                    </div>
                    <div class="course-description">
                        {!!$course->description!!}
                    </div>
                </div>
            </div>
            
            <div class="content-box">
                <div class="mt-4 fs-6" style="width: 100%;">
                    <div class="card-header">
                      <h5>Chapters</h5>
                    </div>
                    <ul class="list-group p-4" style="list-style: none">
                        @foreach ($chapters as $chapter)
                            <li class="px-3 py-4 border mb-2 rounded-3 position-relative" style="cursor: pointer">
                                {{$chapter->title}}
                                <a href="{{route('chapterdetails', ['id'=>base64_encode($chapter->id)])}}">
                                    <button class="btn btn-primary rounded-5 position-absolute end-0">Start</button>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                  </div>
            </div>
        </div>
    </div>

@endsection