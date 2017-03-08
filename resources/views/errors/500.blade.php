@extends('layouts.app')

@section('title')
   Internal Server Error
@endsection

@section('content')
    <div class="placeholder"></div>
    <div class="row">
        <div class="col s10 m8 push-s1 push-m2">
            <div class="card error-card">
                <h4 class="blue-text"><i class="material-icons pink-text">warning</i> 500: Oops... Something went wrong with our server... <br></h4>
                @if(empty($exception->getMessage()))
                    <h5>Contact us for more help</h5>
                @else
                    <h5>{{$exception->getMessage()}}</h5>
                @endif
            </div>
        </div>
    </div>
@endsection