@extends('layouts.app')

@section('title')
    Login
@endsection

@section('style')
	<link rel="stylesheet" href="css/login.css" type="text/css" charset="utf-8" />
@endsection

@section('content')
	<div class="login-card">
        <!--Login Card Placeholder-->
        <div class="login-placeholder"></div>
        <div class="row login-form">
            <form class="col s12" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <h4>Welcome to NoticeBoard.</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
                        <label for="username">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" type="password" name="password" required>
                        <label for="password">Password</label>
                    </div>
                </div>
                <button class="login-btn btn-flat waves-effect waves-light" type="submit">Login</button>
                <a href="{{ url('/password/reset') }}" class="forgot-password-link">FORGOT PASSWORD?</a>
            </form>
        </div>
    </div>
@endsection