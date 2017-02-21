@extends('layouts.app')

@section('title')
    Index
@endsection

@section('searchbar')
    <nav class="search-bar">
        <div class="nav-wrapper">
            <form id="search-form" method="get" action="https://www.bing.com/search" target="_blank"
                  onsubmit="Bingsitesearch(this)">
                <div class="input-field">
                    <input id="search" name="q" type="hidden">
                    <input id="search" name="keyword" type="search" placeholder="Search NoticeBoard" required>
                    <label for="search"><i class="material-icons">search</i></label>
                    <i class="material-icons" onclick="do_search()">done</i>
                </div>
            </form>
        </div>
    </nav>
@endsection

@section('postcard')
    @foreach($posts as $post)
        <div class="post-card">
            <div class="card vertical post-card-content">
                <div class="card-action">
                    <h6 class="subheader post-header hide-on-med-and-down">{{$post->getAuthor->name}}
                        on {{$post->created_at}}</h6>
                    <a href="{{url('/post'.$post->id)}}">Full article</a>
                </div>
                <div class="post-user-profile">
                    <div class="card-image"><img class="circle" src="{{ url($post->getAuthor->avatar) }}"/></div>
                    <div class="post-header-container">
                        <h4 class="header post-header">{{$post->title}}</h4>
                    </div>
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <!--Tags. Limit to 3 per post and their length-->
                        <div class="tag-container">
                            @foreach($post->tags as $tag)
                                <button class="tag-btn btn-flat waves-effect waves-light">#{{$tag->name}}</button>
                                @break($loop->iteration == 3)
                            @endforeach
                        </div>
                        <h6 class="subheader post-header hide-on-large-only">{{$post->getAuthor->name}}
                            on {{$post->created_at}}</h6>
                        <p class="flow-text">
                            @if (strlen($clean = CleanContent($post->content))<=150)
                                {!! $clean !!}
                            @else
                                {!! mb_substr($clean,0,150) !!}...
                            @endif
                        </p>
                    </div>
                    <div class="card-content post-comment-card">
                        @if ($post->last_user != NULL)
                        <div class="card vertical post-card-content">
                            <div class="post-user-profile">
                                    <div class="card-image"><img class="circle" src="{{$post->getLastUser->avatar}}"/></div>
                                    <div class="post-header-container">
                                        <h6 class="header post-header"><span>{{$post->getLast_user->name}}<span
                                                        class="blue-text">commented</span></span> <br>
                                            <span>{{$post->updated_at}}</span></h6>
                                    </div>
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                    <p>
                                        Total reply:{{$post->hasManyComments->count()}}</p>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="post-header-container">
                                <h6 class="header post-header"><strong>No One comments here yet...</strong></h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


@section('content')
@yield('searchbar')
@yield('postcard')
@endsection
