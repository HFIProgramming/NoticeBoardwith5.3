@extends('layouts.app')

@section('title','Complete Your Info')

@section('content')
    <div class="placeholder hide-on-med-and-down"></div>
    <div class="row">
        <div class="col s12 l8 push-l2">
            <div class="card user-info-completion">
                <div class="card-content">
                    <span class="card-title">Please Complete Your User Information</span><br>
                    <form role="form" method="POST" action="{{ url('/completion') }}">

                        {{ csrf_field() }}

                        <div class="input-field">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="name" type="text" name="name" value="{{$user->name}}" placeholder="required" required autofocus>
                            <label for="name">Nick Name</label>

                            @if ($errors->has('name'))
                                <strong class="red-text">{{$errors->first('name')}}</strong>
                            @endif
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">email</i>
                            <input id="email" type="email" name="email" value="{{$user->email}}" placeholder="required" required>
                            <label for="email">E-Mail Address</label>

                            @if ($errors->has('email'))
                                <strong class="red-text">{{ $errors->first('email') }}</strong>
                            @endif
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input id="password" type="password" name="password" placeholder="required" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">lock_outline</i>
                            <input id="password-confirm" type="password" name="password_confirmation" placeholder="required" required>                        
                            <label for="password-confirm">Confirm Password</label>
                            @if ($errors->has('password'))
                                <strong class="red-text">{{ $errors->first('password') }}</strong>
                            @endif
                        </div>

                        <div class="input-field">   
                            <i class="material-icons prefix">assignment_ind</i>
                            <input id="english_name" type="text" class="form-control" name="english_name" placeholder="required" value="{{$user->english_name}}" required>
                            <label for="english_name">English Name</label>

                            @if ($errors->has('english_name'))
                                <strong class="red-text">{{ $errors->first('english_name') }}</strong>
                            @endif
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">phone</i>
                            <input id="phone_number" type="number" name="phone_number" value="{{$user->phone_number}}" placeholder="optional">
                            <label for="phone_number">Phone Number</label>

                            @if ($errors->has('phone_number'))
                                <strong class="red-text">{{ $errors->first('phone_number') }}</strong>
                            @endif
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">chat</i>
                            <input id="wechat" type="text" name="wechat" value="{{$user->wechat}}" placeholder="optional">
                            <label for="wechat">Wechat</label>

                            @if ($errors->has('wechat'))
                                <strong class="red-text">{{ $errors->first('wechat') }}</strong>
                            @endif
                        </div>

                </div>
                <div class="card-action">
                    <button type="submit" class="btn blue no-shadow">Complete your information</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
