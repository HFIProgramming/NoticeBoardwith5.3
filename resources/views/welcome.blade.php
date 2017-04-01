@extends('layouts.app')

@section('title')
    Index
@endsection

@section('searchbar')
    <nav class="search-bar">
        <div class="nav-wrapper">
            <form id="search-form" method="get" action="https://www.bing.com/search" target="_blank" onsubmit="Bingsitesearch(this)">
                <div class="input-field">
                    <input id="search-q" name="q" type="hidden">
                    <input id="search-key" name="keyword" type="search" placeholder="➤  Search NoticeBoard" required>
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
                    <div class="row post-card-heading no-margin">
                        <div class="col l8 hide-on-med-and-down subheader" align="left"><h6>{{$post->user->name}} on {{$post->created_at}}</h6></div>
                        <div class="col l4 right"><a href="{{url('/post/'.$post->id)}}">Full article</a></div>
                    </div>
                </div>
                <div class="post-user-profile">
                    <div class="card-image"><img class="circle scroll-load-image" data-url="{{ url($post->user->avatar) }}" src="/assets/images/blank.png"/></div>
                    <div class="post-header-container">
                        <h5 class="header post-header">{{$post->title}}</h5>
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
                        <h6 class="subheader post-header hide-on-large-only">{{$post->user->name}} on {{$post->created_at}}</h6>
                        <p class="flow-text">
                            @if (strlen($clean = CleanContent($post->content))<=150)
                                {!! $clean !!}
                            @else
                                {!! mb_substr($clean,0,150) !!}...
                            @endif
                        </p>
                    </div>
                    <div class="card-content post-comment-card">
                        @if (($comment = $post->comments->first()) != NULL)
                        <div class="card vertical post-card-content">
                            <div class="post-user-profile">
                                    <div class="card-image"><img class="circle scroll-load-image" data-url="{{$comment->user->avatar}}" src="/assets/images/blank.png"/></div>
                                    <div class="post-header-container">
                                        <h6 class="header post-header">
                                            <span>{{$comment->user->name}}
                                                <span class="blue-text">commented</span>
                                            </span>
                                            <br>
                                            <span>{{$comment->created_at}}</span>
                                        </h6>
                                    </div>
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                    <p>{{$comment->content}}</p>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="post-header-container">
                                <h6 class="header post-header"><strong>No One commented yet...</strong></h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="post-card">
        <div class="card vertical post-card-content">
            <div class="card-content no-padding">  
                {{$posts->links()}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="/js/search.js"></script>
    <script type="text/javascript" src="/js/post.js"></script>
    <script src="//cdn.bootcss.com/tinymce/4.5.2/tinymce.min.js"></script>
@endsection

@section('content')
@yield('searchbar')
@yield('postcard')
@endsection
