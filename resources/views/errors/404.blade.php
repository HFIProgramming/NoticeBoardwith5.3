@extends('layouts.app')

@section('title')
    Page No Found
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @if ($errors->has('warning'))
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>{{ $errors->first('warning') }}</strong> <!--I Hate frontend ! SO THAT ALL-->
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{trans('error.404_sorry')}}</strong>
                    </div>
                    <p>{{trans('error.404_action')}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection