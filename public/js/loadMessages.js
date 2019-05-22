$(document).ready(function() {
    var url = $(this).attr('action');
    var response = '';
    $.ajax({
        type: 'GET',
        url: url,
        dataType: "json",
        async: false,

        success: function(data) {
            /** @namespace data.messages */
            response = data.messages.host;
            var output = '';
            for (var i = 0; i < response.length; i++) {
                output += response[i].message + ' ';
            }
            if (output.length > 0) {
                $(".message-host").append('<div class="cloud"><p class="write-host" style="font-size:15px">' + output + '</p></div>');
            } else {
                null;
            }
        }
    })
});
