@extends('layouts.app')

@section('content')
    {{ csrf_field() }}
    <p>Post Address: {{$url}}</p>
    @foreach ($vote->questions as $question)
        <p>Question:{{$question->content}}</p>
        @foreach($question->options as $option)
            <p>Option:{{$option->content}}</p>
        @endforeach
    @endforeach
@endsection