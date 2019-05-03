$(document).ready(function () {
    $('form[name^="indicator"]').submit(function (event) {
        event.preventDefault();
        var formName = $(this).attr('name');
        var formData = new FormData($("form[name='"+formName+"']")[0]);
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $(".indicators").find('.indicators__messages').empty();
                var message = '<div class="alert alert-success">';
                $.each(data, function (key, value) {
                    message += value + '</br>';
                });
                message += '</div>';
                $(".indicators").find('.indicators__messages').html(message);
                setTimeout(function(){
                //    window.location.reload();
                }, 3000);
            },
            error: function (data) {
                var errorsHtml = '<div class="alert alert-danger"><ul>';
                $.each(data, function (key, value) {
                    errorsHtml += '<li>' + value + '</li>';
                });
                errorsHtml += '</ul></div>';
                $(".indicators").find('.indicators__messages').html(errorsHtml);
            }
        });
    });
});