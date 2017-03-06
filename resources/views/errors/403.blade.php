@extends('layouts.app')

@section('title')
    Access Denied
@endsection

@section('content')
    <div class="placeholder"></div>
    <div class="row">
        <div class="col s10 m8 push-s1 push-m2">
            <div class="card error-card">   
                <h4 class="blue-text"><i class="material-icons pink-text">warning</i> 403: Sorry, but you don't have access to this page <br></h4>
                @if(empty($exception->getMessage()))
                    <h5>Please check your URL or return to the home page.</h5>
                @else
                    <h5>{{$exception->getMessage()}}</h5>
                @endif
            </div>
        </div>
    </div>
@endsection
