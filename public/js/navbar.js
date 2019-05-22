$(document).ready(function() {
   var $navBox = $('.navigation-box');
   var $trigger = $('.trigger');

   $trigger.on('click', function () {
       if ($(this).hasClass('down')) {
           $navBox.animate({
               top: '+=150px'
           }, 1000);

           $(this).removeClass('down');
           $(this).toggleClass('up');

       } else if ($(this).hasClass('up')) {
           $navBox.animate({
               top: '-=150px'
           }, 1000);

           $(this).removeClass('up');
           $(this).toggleClass('down');
       }
   });
});
