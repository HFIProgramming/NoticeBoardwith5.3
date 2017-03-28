@extends('layouts.app')

@section('content')
    {{ csrf_field() }}

    {{var_dump($post)}}
@endsection