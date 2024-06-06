@extends("teacher.layout")

@section('content')
<div class="test-container my-4">
    @foreach ($tests as $test)
    <div class="card" style="width: 18rem;">
        {{-- <img src="" class="card-img-top" alt="..."> --}}
        <div class="card-body">
          <p class="card-title">
            {!!$test->title!!}
          </p>
          <p class="card-text">
            {!!$test->description!!}
          </p>
          <div class="d-sm-flex">
            <a href="{{route('teacher.test.customize', ['id'=>$test->id])}}">
              <button class="btn btn-dark me-2">
                Customize
              </button>
            </a>
            <a href="{{route('test.mcq.result')}}">
              <button class="btn btn-dark">
                Result
              </button>
            </a>
          </div>
          
        </div>
      </div>
    @endforeach
</div>
@endsection