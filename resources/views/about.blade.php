@extends('layouts.app')

@section('title','About Us')

@section('style')
	<link rel="stylesheet" href="css/club.css" type="text/css" charset="utf-8" />
@endsection

@section('content')
	<div class="post-card club-card">
		<div class="card vertical post-card-content">
			<div class="post-user-profile">
				<div class="card-image article-avatar"><img class="club-avatar" src="assets/images/clublogo.png" /></div>
			</div>
			<div class="post-header-container title-container">
				<h4 class="header post-header railway">HFI Programming Club</h4>
			</div>
			<!--Club motto-->
			<div class="post-header-container">
				<h5 class="header post-header railway subheader">Invents future through coding</h5>
			</div>
			<div class="card-stacked">
				<div class="card-content">
					<p class="club-card-text">
						<!--Club description-->
						We are a group of enthusiatic programmers, "indulging" in coding.<br>
						This site, NoticeBoard, is one of our main products. Its functions include but are not limited to: <br>
							- Post Feed<br>
							- File Sharing<br>
							- School-wide Votes<br>
							- Club Information Center<br>
							- Student Profile System<br>
							- Supporting Website for Many School Activities<br>
					</p>
				</div>
			</div>
		</div>
	</div>
	<!--Club card container-->
	<div class="row club-card-container">
		<!--Event list-->
		<div class="post-card card club-event-list club-list col s12 l4 push-l8">
			<ul class="collection with-header">
				<li class="collection-header">
					Upcoming Events
				</li>
				<li class="collection-item">
					<span class="title">聚众肝码</span>
					<p class="subheader">iStudy1号会议室
					</p>
				</li>
			</ul>
		</div>
		<!--Core member list-->
		<div class="member-list-container col s12 l8 pull-l4">
			<div class="post-card card club-member-list club-list">
				<ul class="collection with-header">
					<li class="collection-header">
						Core Members
					</li>
					<li class="collection-item avatar">
						<img src="assets/images/howard.png" alt="" class="circle">
						<span class="title railway">Howard Yu</span>
						<p class="railway subheader italic">社长，后端工程师
						</p>
					</li>
					<li class="collection-item avatar">
						<img src="assets/images/michael.jpg" alt="" class="circle">
						<span class="title railway">Michael Luo</span>
						<p class="railway subheader italic">社长，宣传，市场，公关，运维，后端
						</p>
					</li>
					<li class="collection-item avatar">
						<img src="assets/images/ethan.jpg" alt="" class="circle">
						<span class="title railway">Ethan Hu</span>
						<p class="railway subheader italic">前社长，前端工程师，设计师，财务
						</p>
					</li>
					<li class="collection-item avatar">
						<img src="assets/images/concord.png" alt="" class="circle">
						<span class="title railway">Jerry Li</span>
						<p class="railway subheader italic">前端工程师，设计师
						</p>
					</li>
					<li class="collection-item avatar">
						<img src="assets/images/jhonny.png" alt="" class="circle">
						<span class="title railway">Johnny Jian</span>
						<p class="railway subheader italic">后端工程师，技术支持
						</p>
					</li>
					<li class="collection-item avatar">
						<img src="assets/images/dorothy.jpg" alt="" class="circle">
						<span class="title railway">Dorothy Tian</span>
						<p class="railway subheader italic">宣传，公关
						</p>
					</li>
					<li class="collection-item avatar">
						<img src="assets/images/bazinga.jpg" alt="" class="circle">
						<span class="title railway">Schrieffer Lin</span>
						<p class="railway subheader italic">后端工程师
						</p>
					</li>
				</ul>
			</div>
		</div>
	</div>
@endsection
