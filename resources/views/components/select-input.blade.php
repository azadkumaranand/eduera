@props(['options'])

<select {{ $attributes->merge(['class' => 'form-select Default select example']) }}>
    @foreach ($options as $value=>$label)
        <option value="{{$label}}">{{$value}}</option>
    @endforeach
</select>