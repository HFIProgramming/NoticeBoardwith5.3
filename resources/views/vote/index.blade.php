@extends('layouts.app')

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
        @foreach($votes as $vote)
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1>title{{$vote->title}}</h1><!--I Hate frontend ! SO THAT ALL-->
                            </div>
                            <p>简介：{{empty($vote->intro) ? '暂不可用' : $vote->intro}}</p>
                            <p>结束时间：{{$vote->ended_at}}</p>   <!--结束时间客户端要学会自己判断-->
                            <p>投票人数：{{count(explode("|", $vote->voted_user))-1}}</p>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach