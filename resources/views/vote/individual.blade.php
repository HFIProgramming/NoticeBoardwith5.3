@extends('layouts.app')

@section('content')
    <p>Ticket:{{$request->ticket}}</p>
    <p>Voteid:{{$request->id}}</p>
@endsection