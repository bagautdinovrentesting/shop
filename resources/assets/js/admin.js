window.$ = window.jQuery = require('jquery');
require('bootstrap');

$(document).ready(function() {
    $('.logout-item').click(function (e){
        e.preventDefault();
        $('#logout-form').submit();
    });
});
