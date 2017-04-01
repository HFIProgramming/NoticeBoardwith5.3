@extends('layouts.app')

@section('title')
{{$post->title}}
@endsection

@section('content')
	<div class="post-card article-card">
		<div class="card vertical post-card-content">
			<div class="post-user-profile">
				<div class="card-image article-avatar"><img class="circle scroll-load-image" data-url="{{$post->user->avatar}}" src="/assets/images/blank.png" /></div>
			</div>
			<div class="post-header-container title-container">
				<h5 class="header post-header railway">{{$post->title}}</h5>
			</div>
			<div class="post-header-container">
				<h6 class="header post-header railway article-author">{{$post->user->name}}</h6>
			</div>
			<div class="post-header-container">
				<h6 class="header post-header railway subheader">{{$post->updated_at}}</h6>
			</div>
			<div class="card-stacked">
				<div class="card-content">
					<p class="article-card-text">
						{!!postProcess($post->content)!!}
					</p>
				</div>
			</div>
		</div>
	</div>
	<!--Comment placeholder-->
	@if (($comment = $post->comments->first()) == NULL)
		<div class="article-card comment">
			<div class="post-header-container comment-caption">
				<h5 class="header post-header railway">No Comments Yet</h5>
			</div>
		</div>

	@else
	<div class="article-card comment">
		<div class="post-header-container comment-caption">
			<h5 class="header post-header railway">Comments</h5>
		</div>
	</div>
	<div class="post-card article-card comment-card">
		@foreach($post->comments as $comment)
		<div class="card vertical post-card-content post-comment-card">
			<div class="post-user-profile">
				<div class="card-image"><img class="circle scroll-load-image" data-url="{{$comment->user->avatar}}" src="/assets/images/blank.png" /></div>
				<div class="post-header-container">
					<h6 class="header post-header"><span class="blue-text"><b>{{$comment->user->name}}</b></span></br><span class="grey-text">2016/9/20 1:29</span></h6>
				</div>
			</div>
			<div class="card-stacked">
				<div class="card-content">
					<p class="article-card-text">
						{{$comment->content}}
					 </p>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	@endif
@endsection