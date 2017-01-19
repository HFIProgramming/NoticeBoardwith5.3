@extends('layouts.app')

@section('content')
    <p>Post Address: {{$request->url()}}</p>
    @foreach ($vote->questions as $question)
        <p>Question:{{$question->content}}</p>
        @foreach($question->options as $option)
            <p>Option:{{$option->content}}</p>
        @endforeach
    @endforeach
@endsection