@extends("teacher.layout")

@section('content')
<div class="test-container my-4">
    @foreach ($tests as $test)
    <div class="card" style="width: 18rem;">
        {{-- <img src="" class="card-img-top" alt="..."> --}}
        <div class="card-body">
          <p class="card-title">
            {{$test->title}}: {{$test->test_type}}
          </p>
          <p class="card-text">
            {!!$test->description!!}
          </p>
          <a href="{{route('teacher.test.customize', ['id'=>$test->id])}}">
            <button class="btn btn-dark">
              Customize
            </button>
          </a>
        </div>
      </div>
    @endforeach
</div>
@endsection