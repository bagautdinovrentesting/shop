require('./bootstrap');

$(document).ready(function() {
    $('.logout-item').click(function (e){
        e.preventDefault();
        $('#logout-form').submit();
    });

    $(".carousel-swipe").swipe( {
        swipeLeft: function() {
            $(this).carousel("next");
        },
        swipeRight: function() {
            $(this).carousel("prev");
        },
        allowPageScroll: "vertical"
    });
});

