@extends('layouts.app')

@section('title')
	{{$ticket->voteGroup->title}}
@endsection

@section('content')
	{{--We need a place to put intro for group @TODO!--}}
	@foreach($ticket->voteGroup->votes as $vote)
		<div class="post-card">
			<div class="card vertical post-card-content">
				<div class="card-action">
					<div class="row post-card-heading no-margin">
						<div class="col s5 subheader" align="left"><h6>By {{$vote->getAuthor->name}}</h6></div>
						@if (!$ticket->isTicketUsed($vote->id))
							@if (strtotime($vote->started_at) - strtotime('now') > 0)
								<div class="col s7 right"><a href="#">@lang('vote.vote_not_started_button')</a></div>
							@elseif (strtotime($vote->ended_at) - strtotime('now') < 0)
								<div class="col s7 right"><a href="{{url('/vote/id/'.$vote->id.'/ticket/'.$ticket->string.'/result/')}}">@lang('vote.vote_closed_button')</a></div>
							@else
								<div class="col s7 right"><a href="{{url('/vote/id/'.$vote->id.'/ticket/'.$ticket->string)}}">@lang('vote.vote_now_button')</a></div>
							@endif
						@else
							<div class="col s7 right"><a href="{{url('/vote/id/'.$vote->id.'/ticket/'.$ticket->string.'/result/')}}">@lang('vote.voted_button')</a></div>
						@endif
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
							<button class="tag-btn btn-flat waves-effect waves-light">开始时间：{{date('Y/n/j G:i', strtotime($vote->started_at))}}</button>
							<button class="tag-btn btn-flat waves-effect waves-light">结束时间：{{date('Y/n/j G:i', strtotime($vote->ended_at))}}</button>
							<button class="tag-btn btn-flat waves-effect waves-light">投票人数：{{count($vote->votedIds())}}</button>
						</div>
						<br>
                    	<div>{{$vote->intro}}</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach

@endsection
