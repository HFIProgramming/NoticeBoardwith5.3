@extends('layouts.app')

@section('title')
    {{$vote->title}}
@endsection

@section('content')
    <div class="post-card">
        <div class="card vertical post-card-content">
            <div class="card-action">
                <div class="row post-card-heading no-margin">
                    <div class="col s12 subheader" align="left"><h6>{{$vote->getAuthor->name}} on {{$vote->created_at}}</h6></div>
                </div>
            </div>
            <div class="post-user-profile">
                <div class="card-image"><img class="circle" src="{{ url($vote->getAuthor->avatar) }}"/></div>
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
                    <div>{{$vote->intro}}</div>
                    <br>

                    {{--Important!!!! This form will return all IDs of selected items in JSON in the name of "selected" !--}}
                    {{--选项id结构设置为"vote-item-{id}"，其中，{id}请改为改选项在数据库中的primary key 值--}}
                    <form id="vote-form" action="" method="post" accept-charset="utf-8">
                        <input type="hidden" name="selected" id="vote-selected">
                        {{ csrf_field() }}
                        @each ('vote.question',$vote->questions, 'question')
                    </form>
                </div>
            </div>
            <div class="card-action">

                <div class="btn waves-effect waves-light blue no-shadow" onclick="doVote()">Submit
                    <i class="material-icons right">send</i>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="/js/vote.js"></script>
@endsection
