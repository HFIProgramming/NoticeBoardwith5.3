$(".button-collapse").sideNav();
$(document).ready(function () {
    //Give each post-card its colour
    var postcards = $('.post-card');
    for (var i = 0; i < (postcards.length); i++) {
        if (i % 2 === 0) {
            $(postcards[i]).addClass('post-white');
        } else {
            $(postcards[i]).addClass('post-grey');
        }
    }

    //If comments placeholder is needed
    var comments = $('.comment-card');
    if (comments.length == 1) {
        $('.comment-card').css('display', 'block');
    }
});

//Google Analytics
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

try {
    // 防止载入过慢
    ga('create', 'UA-85513844-4', 'auto');
    ga('send', 'pageview');
} catch (e) {
}

