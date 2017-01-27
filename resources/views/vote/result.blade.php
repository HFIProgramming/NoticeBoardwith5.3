@extends('layouts.app')

@section('content')
    <p>Post Title {{$vote->first()->title}}</p>
    @foreach ($vote->questions as $question)
        <h2>Question:{{$question->content}}</h2>
        @foreach ($results as $key => $value)
            @if ($value['questionId'] == $question->id)
        <h3>Option: {{\App\Option::where('id',$key)->first()->content}};ID:{{$key}}</h3>
        <h4>Count: {{$value['count']}}</h4>
        @endif
            @endforeach
    @endforeach
@endsection