$(document).ready(function() {

  var plus = $('.plus');
  var minus = $('.minus');

    minus.on('click', function() {
        $('.write-host').css("font-size", function() {
            return parseInt($(this).css('font-size')) - 1 + 'px';
        });
    });
    plus.on('click', function() {
        $('.write-host').css("font-size", function() {
            return parseInt($(this).css('font-size')) + 1 + 'px';
        });
    });
});
