$(document).ready(function() {
   $('tr.profile').on('click', function() {
       var active = $(this).toggleClass('active');
       var dataProfile = $(this).data('profile');
       $('input[name="data-profile-value"]').attr('value', dataProfile);
   });
});
