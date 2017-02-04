@extends('layouts.app')

@section('title')
    Access Deny
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
                        <strong>{{Lang::get('auth.403_sorry')}}</strong>
                    </div>
                </div>
                <p>{{Lang::get('auth.403_action')}}</p>
            </div>
            @endif
        </div>
    </div>
@endsection