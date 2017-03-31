@extends('layouts.app')

@section('title')
    {{$vote->title}}
@endsection

@section('content')
<div class="post-card">
        <div class="card vertical post-card-content">
            <div class="card-action">
                <div class="row post-card-heading no-margin">
                    <div class="col s12 subheader" align="left"><h6>{{$vote->user->name}} at {{date('Y/n/j G:i', strtotime($vote->created_at))}}</h6></div>                </div>
            </div>
            <div class="post-user-profile">
                <div class="card-image"><img class="circle" src="{{url($vote->user->avatar)}}" /></div>
                <div class="post-header-container">
                    <h5 class="header post-header">{{$vote->title}}</h5>
                </div>
            </div>
            <div class="card-stacked">
                <div class="card-content display-all">
                    <!--Tags. Limit to 3 per post and their length-->
                    <div class="tag-container">
                        <button class="tag-btn btn-flat waves-effect waves-light">结束时间：{{$vote->ended_at}}</button>
                        <button class="tag-btn btn-flat waves-effect waves-light">投票人数：{{count($vote->votedIds())}}</button>
                    </div>
                    <br>

                    @foreach($vote->questions as $question)
                        <!-- Vote Question Block: Copy this block for multi-questions -->
                        <div class="vote-block">
                            <p class="flow-text">{{$question->content}}</p>
                            <br>
                            <div class="vote-info row">
                                <div>{{$question->explanation}}</div>
                                <br>

                                @foreach($question->options as $option)
                                        <div class="vote-result-pack col s12 l3">
                                            <div>{{$option->content}}</div>
                                            <div class="progress no-margin"><div class="determinate" style="width: {{round(($option->getTotalNumber()/$question->getTotalNumber())*100,2)}}%"></div></div>
                                            <div align="right">{{count($option->answers)}} Votes, {{round(($option->getTotalNumber()/$question->getTotalNumber())*100,2)}}%</div>
                                        </div>
                                @endforeach

                            </div>
                        </div>
                        <!--End Vote Question Block-->
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="/js/vote.js"></script>
@endsection
