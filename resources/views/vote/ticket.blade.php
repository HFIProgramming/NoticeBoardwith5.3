@extends('layouts.app')

@section('content')
<div class="post-card">
    <div class="card-panel white lighten-2 no-shadow" style="border-radius: 0">
        <h4 class="blue-text">Ticket Generator</h4>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/vote/ticket') }}">
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
                <label for="email" class="col-md-4 control-label">Vote ID</label>

                <div class="col-md-6">
                    <input id="vote_id" type="number" class="form-control" name="vote_id"
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
