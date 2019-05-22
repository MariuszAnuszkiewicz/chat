$(document).ready(function() {
    $('#chatForm').on('submit', function() {
        var method = $(this).attr('method');
        var url = $(this).attr('action');
        var form = $(this).serializeArray();
        var message = $('.textarea-message').val();
        var output = '';

        if (message !== '') {
            $.ajax({
                type: method,
                url: url,
                data: form,
                dataType: "json",
                async: false,

                success: function (data, textStatus, jqXHR) {
                    jQuery.each(form, function(i, fields) {
                        if (fields.name === 'message') {
                            if (textStatus === 'success') {
                                output += JSON.stringify(fields.value);
                                $('#save_status').append('Data save successfully');
                            }
                        }
                    });
                },

                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            })
         }
    });
});
