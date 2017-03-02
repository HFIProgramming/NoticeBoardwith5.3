<!DOCTYPE html>
<html lang="zh_CN">
<head>
    <!--Let browser know website is optimized for mobile-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <meta content="telephone=no" name="format-detection"/>
    {{--Wechat Repost Image--}}
    <div id='wx_pic' style='margin:0 auto;display:none;'>
        <img src='https://hfinotice-web.nos-eastchina1.126.net/nb.png' />
    </div>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - NoticeBoard</title>

    <!--Import Style Sheets from external source-->
    <link type="text/css" rel="stylesheet" href="//cdn.bootcss.com/materialize/0.98.0/css/materialize.min.css"
          media="screen,projection"/>
    <!--self-->
    <link rel="stylesheet" href="/css/external/railwaysans/stylesheet.css" type="text/css" charset="utf-8"/>
    <link rel="stylesheet" href="/css/main.css" type="text/css" charset="utf-8"/>
    {{--Basic Styles--}}
    <style>
        @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
            src: url(https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/MaterialIcons-Regular.eot);
            /* For IE6-8 */
            src: local('Material Icons'), local('MaterialIcons-Regular'), url(https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/MaterialIcons-Regular.woff2) format('woff2'), url(https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/MaterialIcons-Regular.woff) format('woff'), url(https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/MaterialIcons-Regular.ttf) format('truetype');
        }
        body {
            background: url(https://ws1.sinaimg.cn/large/006dLiLIly1fcnq352qm5j31kw0ro1jr) fixed;
        }
        #navbar-container nav {
            background: url(https://ws1.sinaimg.cn/large/006dLiLIly1fcnq352qm5j31kw0ro1jr);
        }
    </style>
@yield('style')
<!--End Import Styles-->
</head>

<body>
<!--Side Nav-->
<ul id="slide-out-panel" class="side-nav">
    <img class="side-background" src="https://ws1.sinaimg.cn/large/006dLiLIgy1fcnq8jyve9j31hc0zmdqr"></img>
    <li>
        <div class="userView">
            @if ($user = Auth::user())
                <a href="/me/edit"><img class="circle" src="{{url($user->avatar)}}"></a>
                <a href="/me"><span class="white-text name">{{$user->name}}</span></a>
                <span class="white-text email">{{$user->email}}</span>
            @else
                <a href="/login"><img class="circle" src="https://ww4.sinaimg.cn/small/006dLiLIgw1fawexxhv3hj31hc1hcdzh.jpg"></a>
                <a href="/login"><span class="white-text name">Please Login and Enjoy.</span></a>
            @endif
            {{--<img class="background" src="assets/images/avatar-background.jpg">--}}
        </div>
    </li>
    <li><a href="/me/notification" class="waves-effect"><i class="material-icons">view_stream</i>My Notification</a></li>
    <li><a href="/powerschool" class="waves-effect"><i class="material-icons">school</i>Powerschool</a></li>
    <li><a href="/more/selling-books" class="waves-effect"><i class="material-icons">shop_basket</i>Marketplace</a></li>
    <li><a href="/clubs" class="waves-effect"><i class="material-icons">cloud</i>Clubs</a></li>
    <li><a href="/more/danmaku" class="waves-effect"><i class="material-icons">comment</i>Danmaku</a></li>
    <li>
    <li>
        <div class="divider"></div>
    </li>
    @if ($user = Auth::user())
        <li><a class="subheader">Account</a></li>
        <li><a class="waves-effect" href="/me"><i class="material-icons">settings</i>Settings</a></li>
        <li><a class="waves-effect" href="/logout"><i class="material-icons">exit_to_app</i>Sign out</a></li>
    @else
        <li><a class="subheader">Actions</a></li>
        <li><a class="waves-effect" href="/login"><i class="material-icons">open_in_browser</i>Login</a></li>
        <li><a class="waves-effect" href="/aboutus"><i class="material-icons">info_outline</i>About us</a></li>
    @endif
</ul>
<!--Nav bar-->
<div class="navbar" id="navbar-container">
    <nav style="box-shadow: none">
        <div class="nav-wrapper" id="navbar">
            {{--
            @TODO Disabled for International Day,Removed when finished
                <a href="#" data-activates="slide-out-panel" class="button-collapse push-l3 menu-button"><i
                        class="material-icons">menu</i></a>
            --}}
            <a href="/"><img class="nb-logo brand-logo center" src="https://hfinotice-web.nos-eastchina1.126.net/logo.png"></img></a>
            {{--
            @TODO Disabled for International Day,Removed when finished
                <ul id="nav-mobile" class="right">
                    <li><a href="#new-post"><i class="material-icons add-button">add</i></a></li>
                </ul>
            --}}
        </div>
    </nav>
</div>

<main>
    <!--Content-->
    @yield('content')
    <!--end Content-->
</main>

<footer>
    <div class="post-card article-card about">
        <h5 class="subheader center-align">©2015-{{date('Y')}} HFIProgramming</h5>
    </div>
</footer>
</body>

<!--Scripts from external source-->
<script type="text/javascript" src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.bootcss.com/materialize/0.98.0/js/materialize.min.js"></script>
<!--self-->
<script type="text/javascript" src="/js/main.js"></script>
@yield('script')
<!--End Scripts-->

</html>
