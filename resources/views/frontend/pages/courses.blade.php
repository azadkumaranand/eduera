@extends('frontend.layouts.layout')


@section('content')

<!-- Courses Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Available Courses</h6>
            {{-- <h1 class="mb-5">All Courses</h1> --}}
        </div>
        <div class="row g-4 justify-content-center">
            @if (count($courses) <= 0)
                <h3 class="text-center">Comming Soon....</h3>
            @endif
            @foreach ($courses as $course)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light shadow-sm">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="assets/img/course-1.jpg" alt="">
                        </div>
                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">Rs {{$course->price}}</h3>
                            <div class="mb-3">
                                <span class="text-primary h6">4.8</span>
                                <small class="fa fa-star text-primary"></small>
                                <small>(123)</small>
                            </div>
                            <h5 class="mb-4">{{$course->title}}</h5>
                        </div>
                        <div class="d-flex justify-content-center border-top">
                                <a href="{{route('coursedetails', ['id'=>base64_encode($course->id)])}}" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Join Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Courses End -->

@endsection