@extends('layouts.app')

@section('title')
    Login
@endsection

@section('style')
    <link rel="stylesheet" href="css/login.css" type="text/css" charset="utf-8"/>
@endsection

@section('content')
    <div class="placeholder"></div>
    <div class="row">
        <div class="col s10 push-s1 m8 push-m2 login-card">
            <div class="login-placeholder">
            <!--Login Card Placeholder-->
            </div>
            <div class="row login-form">
                <form role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <h4 class="col s12 l8 push-l2">Welcome to NoticeBoard.</h4>
                    </div>
                    <div class="row">
                        <div class="input-field col s10 push-s1 l8 push-l2">
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required
                                   autofocus>
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 0">
                        <div class="input-field col s10 push-s1 l8 push-l2">
                            <input id="password" type="password" name="password" required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <div class="row">
                            <strong class="col red-text s10 push-s1 l8 push-l2">{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                    @if ($errors->has('warning'))
                        <div class="row">
                            <strong class="col red-text s10 push-s1 l8 push-l2">{{ $errors->first('warning') }}</strong>
                        </div>
                    @endif
                    <br>
                    <div class="row">
                        <button class="col s4 left login-btn btn-flat waves-effect waves-light" type="submit" align="center">Login</button>
                        <a href="{{ url('/password/reset') }}" class="col s8 l4 right login-btn btn-flat waves-effect waves-light forgot-password-link" align="center">FORGOT PASSWORD?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
