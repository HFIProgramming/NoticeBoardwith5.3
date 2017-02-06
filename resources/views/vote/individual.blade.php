@extends('layouts.app')

@section('content')
    {{ csrf_field() }}
    <p>Post Address: {{$url}}</p>
    @foreach ($vote->questions as $question)
        <h2>Question:{{$question->content}}</h2>
        @foreach($question->options as $option)
            <h3>Option ID : {{$option->id}}</h3>
            <p>Content:{{$option->content}}</p>
        @endforeach
    @endforeach
@endsection