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
    </style>
@yield('style')
<!--End Import Styles-->
</head>

<body>
<main>
    <!--Content-->
    @yield('content')
    <!--end Content-->
</main>

<!--Scripts from external source-->
<script type="text/javascript" src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.bootcss.com/materialize/0.98.0/js/materialize.min.js"></script>
<!--self-->
<script type="text/javascript" src="/js/scroll_loading.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
@yield('script')
<!--End Scripts-->

</html>
