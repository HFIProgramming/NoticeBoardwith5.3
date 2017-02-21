@extends('layouts.app')

@section('title')
    {{$vote->id}} - NoticeBoard;
@endsection

@section('content')
    <div class="post-card">
        <div class="card vertical post-card-content">
            <div class="card-action">
                <div class="row post-card-heading no-margin">
                    <div class="col s12 subheader" align="left"><h6>{{$vote->getAuthor->name}}
                            on {{$vote->created_at}}</h6></div>
                </div>
            </div>
            <div class="post-user-profile">
                <div class="card-image"><img class="circle" src="{{ url($vote->getAuthor->avatar) }}"/></div>
                <div class="post-header-container">
                    <h5 class="header post-header">{{$vote->intro}}</h5>
                </div>
            </div>
            <div class="card-stacked">
                <div class="card-content display-all">
                    <!--Tags. Limit to 3 per post and their length-->
                    <div class="tag-container">
                        <button class="tag-btn btn-flat waves-effect waves-light">#International Day</button>
                        <button class="tag-btn btn-flat waves-effect waves-light">#Fuck PHP</button>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="post" enctype="text/plain" name="action">
        {{ csrf_field() }}
        @each ('vote.question',$vote->questions, 'question')
        <div class="post-card">
            <div class="card vertical post-card-content">
                <div class="card-content display-all">
                    <br>
                    <p class="flow-text">{{$vote->end_word or "Finish? then Submit!"}}</p>
                    <br>
                    <div class="card-action">
                        <button class="btn waves-effect waves-light blue no-shadow" type="submit" name="action">Submit
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection
