window.$ = window.jQuery = require('jquery');

$(document).ready(function() {
    $('.logout-item').click(function (e){
        e.preventDefault();
        $('#logout-form').submit();
    });
});
