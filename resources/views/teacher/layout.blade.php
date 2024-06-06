<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    {{-- @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx']) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @yield('addStyle')
</head>

<body>
    <div class="container-fluid row">
        <div class="col-lg-2 col-md-3 position-sticky top-0 d-md-flex flex-column d-none bg-dark vh-100">
            <div class="logo my-3 d-flex justify-content-center">
                <x-application-light-logo/>
            </div>
            <ul class="nav flex-column text-left">
                <li class="nav-item my-2 border border-4 border-top-0 border-bottom-0 border-start-0 {{Request::is('courses')?'border-end-4':'border-end-0'}} border-primary">
                  <a class="nav-link text-light fw-bold" href="{{route('courses.index')}}">Courses</a>
                </li>
                <li class="nav-item my-2 border border-4 border-top-0 border-bottom-0 border-start-0 {{Request::is('courses/create')?'border-end-4':'border-end-0'}} border-primary">
                  <a class="nav-link text-light fw-bold" href="{{route('courses.create')}}">Create Course</a>
                </li>
                <li class="nav-item my-2 border border-4 border-top-0 border-bottom-0 border-start-0 {{Request::is('teacher/test')?'border-end-4':'border-end-0'}} border-primary">
                  <a class="nav-link text-light fw-bold" href="{{route('teacher.test')}}">Tests</a>
                </li>
                <li class="nav-item my-2 border border-4 border-top-0 border-bottom-0 border-start-0 {{Request::is('teacher/test/create')?'border-end-4':'border-end-0'}} border-primary">
                  <a class="nav-link text-light fw-bold" href="{{route('teacher.test.create')}}">Create Test</a>
                </li>
              </ul>
        </div>
        <div class="col-lg-10 col-md-9 p-3">
            @yield('content')
        </div>
    </div>
    @yield('addScript')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>