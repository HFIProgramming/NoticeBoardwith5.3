$(".button-collapse").sideNav();
$(document).ready(function () {
    //Give each post-card its colour
    var postcards = $('.post-card');
    for (var i = 0; i < (postcards.length); i++) {
        if (i % 2 == 0) {
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