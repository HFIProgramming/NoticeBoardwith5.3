@extends('test')

@section('title','article page')

@section('content')
	<div class="post-card article-card">
		<div class="card vertical post-card-content">
			<div class="post-user-profile">
				<div class="card-image article-avatar"><img class="circle" src="assets/images/avatar.jpg" /></div>
			</div>
			<div class="post-header-container title-container">
				<h3 class="header post-header railway">Recruiting PY-trade partners</h3>
			</div>
			<div class="post-header-container">
				<h5 class="header post-header railway subheader">A legend worth cherishing</h5>
			</div>
			<div class="post-header-container">
				<h6 class="header post-header railway article-author">Ludwig van Beethoven</h6>
			</div>
			<div class="post-header-container">
				<h6 class="header post-header railway subheader">2016/10/19 23:20</h6>
			</div>
			<div class="card-stacked">
				<div class="card-content">
					<p class="article-card-text">
						Ludwig van Beethoven was a German composer. A crucial figure in the transition between the Classical and Romantic eras in
						Western art music, he remains one of the most famous and influential of all composers. His best-known compositions
						include 9 symphonies, 5 piano concertos, 1 violin concerto, 32 piano sonatas, 16 string quartets, his great Mass the
						Missa solemnis and an opera, Fidelio. Ludwig van Beethoven was a German composer. A crucial figure in the transition
						between the Classical and Romantic eras in Western art music, he remains one of the most famous and influential of
						all composers. His best-known compositions include 9 symphonies, 5 piano concertos, 1 violin concerto, 32 piano sonatas,
						16 string quartets, his great Mass the Missa solemnis and an opera, Fidelio. Ludwig van Beethoven was a German composer.
						A crucial figure in the transition between the Classical and Romantic eras in Western art music, he remains one of
						the most famous and influential of all composers. His best-known compositions include 9 symphonies, 5 piano concertos,
						1 violin concerto, 32 piano sonatas, 16 string quartets, his great Mass the Missa solemnis and an opera, Fidelio. Ludwig
						van Beethoven was a German composer. A crucial figure in the transition between the Classical and Romantic eras in
						Western art music, he remains one of the most famous and influential of all composers. His best-known compositions
						include 9 symphonies, 5 piano concertos, 1 violin concerto, 32 piano sonatas, 16 string quartets, his great Mass the
						Missa solemnis and an opera, Fidelio.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="article-card comment">
		<div class="post-header-container comment-caption">
			<h3 class="header post-header railway">Comments</h3>
		</div>
	</div>
	<!--Comment placeholder-->
	<div class="post-card article-card comment-card comment-placeholder">
		<h4>No comments yet. Anything to write about?</h4>
	</div>
	<div class="post-card article-card comment-card">
		<div class="card vertical post-card-content">
			<div class="post-user-profile">
				<div class="card-image"><img class="circle" src="assets/images/avatar.jpg" /></div>
				<div class="post-header-container">
					<h5 class="header post-header">Ludwig van Beethoven</br>2016/9/20 1:29</h5>
				</div>
			</div>
			<div class="card-stacked">
				<div class="card-content">
					<p class="article-card-text">
						To be, or not to be, that is the question.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="post-card article-card comment-card">
		<div class="card vertical post-card-content">
			<div class="post-user-profile">
				<div class="card-image"><img class="circle" src="assets/images/avatar.jpg" /></div>
				<div class="post-header-container">
					<h5 class="header post-header">Ludwig van Beethoven</br>2016/9/20 1:29</h5>
				</div>
			</div>
			<div class="card-stacked">
				<div class="card-content">
					<p class="article-card-text">
						To be, or not to be, that is the question.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="post-card article-card comment-card">
		<div class="card vertical post-card-content">
			<div class="post-user-profile">
				<div class="card-image"><img class="circle" src="assets/images/avatar.jpg" /></div>
				<div class="post-header-container">
					<h5 class="header post-header">Ludwig van Beethoven</br>2016/9/20 1:29</h5>
				</div>
			</div>
			<div class="card-stacked">
				<div class="card-content">
					<p class="article-card-text">
						To be, or not to be, that is the question.</p>
				</div>
			</div>
		</div>
	</div>
@endsection