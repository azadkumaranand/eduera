@extends('frontend.layouts.layout')

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            @foreach ($crousel as $item)
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="assets/img/carousel-1.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Online Courses</h5>
                                <h1 class="display-3 text-white animated slideInDown">{{$item['title']}}</h1>
                                <p class="fs-5 text-white mb-4 pb-2">{{$item['description']}}</p>
                                <a href="{{url('/web/courses')}}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                @isset($item['price'])
                                     <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Skilled Instructors</h5>
                            <p>Learn from industry experts with years of experience in web development. Our skilled instructors are here to guide you every step of the way.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5 class="mb-3">Online Classes</h5>
                            <p>Access our courses anytime, anywhere. Enjoy the flexibility of online learning with high-quality video lessons and interactive content.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-home text-primary mb-4"></i>
                            <h5 class="mb-3">Home Projects</h5>
                            <p>Apply what you learn with practical projects you can complete at home. Build real-world applications and enhance your portfolio.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Book Library</h5>
                            <p>Dive into our extensive library of resources. Access e-books, articles, and tutorials to supplement your learning and expand your knowledge.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="assets/img/about.jpg" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                    <h1 class="mb-4">Welcome to CodeMintro</h1>
                    <p class="mb-4">At CodeMintro, we believe in empowering you to achieve your dreams through quality education in web development. Our mission is to provide comprehensive and flexible online courses that cater to all skill levels. Whether you're just starting out or looking to advance your career, our expert instructors are here to guide you every step of the way.</p>
                    <p class="mb-4">Join our global community of learners and gain the skills you need to succeed in the digital world. With CodeMintro, you can learn from the best, earn international certificates, and access a wealth of resources anytime, anywhere.</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Certificate</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Home Projects</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Extensive Book Library</p>
                        </div>
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="{{url('/about')}}">Read More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Courses Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Courses</h6>
                <h1 class="mb-5">Popular Courses</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @if (count($courses)<=0)
                    <h5 class="text-center">Comming Soon....</h5>
                @endif 
                @foreach ($courses as $course)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light shadow-sm">
                            <div class="position-relative overflow-hidden course-img">
                                @isset($course->thumbnail)
                                    <img src="{{Storage::url($course->thumbnail)}}" alt="">
                                @else
                                    <img class="img-fluid" src="assets/img/course-1.jpg" alt="">
                                @endisset
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
                                    <a href="{{route('coursedetails', ['id'=>base64_encode($course->id)])}}" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end my-2" style="border-radius: 30px;">Start Learning</a>
                                    {{-- <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Join Now</a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Courses End -->
    <!-- Test Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Courses</h6>
                <h1 class="mb-5">Available Test</h1>
            </div>
            
            <div class="row g-4 justify-content-center">
                @if (!isset($tests))
                    <h5>Comming Soon....</h5>
                @endif
                @foreach ($tests as $test)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="course-item bg-light shadow-sm">
                            <div class="position-relative overflow-hidden">
                                <img class="img-fluid" src="assets/img/course-1.jpg" alt="">
                            </div>
                            <div class="text-center p-4 pb-0">
                                @isset($test->price)
                                    <h3 class="mb-0">Rs {!!$test->price!!}</h3>
                                @endisset
                                
                                <div class="mb-3">
                                    <span class="text-primary h6">4.8</span>
                                    <small class="fa fa-star text-primary"></small>
                                    <small>(123)</small>
                                </div>
                                <h5 class="mb-4">{!!$test->title!!}</h5>
                            </div>
                            <div class="d-flex justify-content-center border-top">
                                    <a href="{{route('test.detail', ['id'=>base64_encode($test->id)])}}" class="flex-shrink-0 btn btn-sm btn-primary px-3 my-2 border-end" style="@isset($test->price) border-radius: 30px 0 0 30px;@endisset @unless($test->price) border-radius: 30px @endunless">View Details</a>
                                    @isset($test->price)
                                    {{-- <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Join Now</a> --}}
                                    @endisset
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Test End -->


    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Instructors</h6>
                <h1 class="mb-5">Expert Instructors</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="assets/img/team-1.jpg" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Ravi Sharma</h5>
                            <small>Senior Web Development Instructor</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="assets/img/team-2.jpg" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Priya Patel</h5>
                            <small>Full-Stack Developer Instructor</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="assets/img/team-3.jpg" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Ankit Verma</h5>
                            <small>Frontend Development Instructor</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="assets/img/team-4.jpg" alt="">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">Meera Iyer</h5>
                            <small>Backend Development Instructor</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
                <h1 class="mb-5">Our Students Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="assets/img/testimonial-1.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Aditi Rao</h5>
                    <p>Web Developer</p>
                    <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">CodeMintro transformed my career. The courses are comprehensive and the instructors are incredibly knowledgeable. I went from a complete beginner to a proficient web developer in just a few months!</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="assets/img/testimonial-2.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Rajesh Kumar</h5>
                    <p>Software Engineer</p>
                    <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">The flexibility of online classes at CodeMintro allowed me to learn at my own pace. The hands-on projects and practical approach to teaching made a huge difference in my learning journey.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="assets/img/testimonial-3.jpg" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">Sneha Gupta</h5>
                    <p>Freelance Developer</p>
                    <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">I loved the structured curriculum and the support from the instructors at CodeMintro. The resources provided were top-notch, and I gained the confidence to start my freelance career.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
@endsection