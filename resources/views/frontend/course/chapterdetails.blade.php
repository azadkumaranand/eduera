@extends('frontend.layouts.layout')


@section('content')
<div class="container my-3 py-3">
    <h4 class="text-secondary">{{$result[0]->chapter_title}}</h4>
    <div class="chapter_desc text-secondary" style="line-height: 30px font-size:23px">
        {!!$result[0]->chapter_desc!!}
    </div>
    
    <div class="chapter_content">
        @foreach ($result as $item)
            <h6>{!!$item->content_title!!}</h6>
            <div>{!!$item->content_desc!!}</div>
        @endforeach
    </div>
    
</div>
@endsection