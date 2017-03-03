@extends('layouts.app')

@section('title')
    Error!
@endsection

@section('content')
    <div class="placeholder"></div>
    <div class="row">
        @if ($errors->has('warning'))
            <div class="col s10 m8 push-s1 push-m2">
                <div class="card error-card">
                    <h4 class="blue-text"><i class="material-icons pink-text">warning</i> Sorry, but we have detected an error <br></h4>
                    <h5>{{$errors->first('warning')}}</h5>
                </div>
            </div>
        @else
            <div class="col s10 m8 push-s1 push-m2">
            <div class="card error-card">
                <h4 class="blue-text"><i class="material-icons pink-text">warning</i> Sorry, but we have detected an error <br></h4>
                <h5>Please check your URL or return to the home page</h5>
            </div>
        </div>
        @endif

    </div>
@endsection