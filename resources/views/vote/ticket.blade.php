@extends('layouts.app')

@section('title','Ticket Generator');

@section('content')
@if(count($errors) > 0)
<div class="post-card" style="margin-bottom:0;">
    <div class="card-panel red lighten-2 no-shadow" style="margin: 0;border-radius: 0">
        <div class="white-text">
            <div style="display:inline-block;line-height: 2rem; height: 2rem; position: relative; top: 0.2rem"><i class="material-icons">error</i></div>
            <h5 style="display: inline-block;line-height: 2rem; height: 2rem;">Error!</h5>
            <div>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
<div class="post-card">
    <div class="card-panel white lighten-2 no-shadow" style="border-radius: 0">
        <h4 class="blue-text">Ticket Generator</h4>
        <form class="form-horizontal" method="post" action="/admin/vote/ticket" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('length') ? ' has-error' : '' }}">
                <label for="length" class="col-md-4 control-label">Length</label>

                <div class="col-md-6">
                    <input id="length" type="text" class="form-control" name="length"
                           value="{{ old('length') }}" required autofocus>

                    @if ($errors->has('length'))
                        <span class="help-block">
                        <strong>{{ $errors->first('length') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('prefix') ? ' has-error' : '' }}">
                <label for="english_name" class="col-md-4 control-label">Prefix</label>

                <div class="col-md-6">
                    <input id="prefix" type="prefix" class="form-control" name="prefix"
                           value="{{ old('prefix') }}">

                    @if ($errors->has('prefix'))
                        <span class="help-block">
                        <strong>{{ $errors->first('prefix') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('vote_id') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Vote Group ID</label>

                <div class="col-md-6">
                    <input id="vote_id" type="number" class="form-control" name="vote_group_id"
                           value="{{ old('vote_id') }}" required>

                    @if ($errors->has('vote_id'))
                        <span class="help-block">
                        <strong>{{ $errors->first('vote_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
                <label for="number" class="col-md-4 control-label">Number</label>

                <div class="col-md-6">
                    <input id="number" type="text" class="form-control" name="number"
                           value="{{ old('number') }}" placeholder="optional">

                    @if ($errors->has('number'))
                        <span class="help-block">
                        <strong>{{ $errors->first('number') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Generate Tickets
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
