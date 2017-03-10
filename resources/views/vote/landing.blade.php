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
						@if (!$ticket->isTicketUsed($vote->id))
							@if (strtotime($vote->started_at) - strtotime('now') > 0)
								<div class="col l4 right"><a href="#">Vote Not Started</a></div>
							@elseif (strtotime($vote->ended_at) - strtotime('now') < 0)
								<div class="col l4 right"><a href="{{url('/vote/id/'.$vote->id.'/ticket/'.$ticket->string.'/result/')}}">Vote Closed, See Results</a></div>
							@else
								<div class="col l4 right"><a href="{{url('/vote/id/'.$vote->id.'/ticket/'.$ticket->string)}}">Vote Now!</a></div>
							@endif
						@else
							<div class="col l4 right"><a href="{{url('/vote/id/'.$vote->id.'/ticket/'.$ticket->string.'/result/')}}">You Voted, See Results</a></div>
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
							<button class="tag-btn btn-flat waves-effect waves-light">
								开始时间：{{$vote->started_at}}</button>
							<button class="tag-btn btn-flat waves-effect waves-light">结束时间：{{$vote->ended_at}}</button>
							<button class="tag-btn btn-flat waves-effect waves-light">
								投票人数：{{count($vote->votedIds())}}</button>
						</div>
						<br>
                    	<div>{{$vote->intro}}</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach

@endsection
