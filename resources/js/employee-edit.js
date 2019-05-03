$(document).ready(function () {
    $('form[name="employeeUpdateForm"]').submit(function (event) {
        event.preventDefault();
        var formData = new FormData($('form[name="employeeUpdateForm"]')[0]);
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
                $('form[name="employeeUpdateForm"]').parent().find('.form-errors').empty();
                var message = '<div class="alert alert-success">';
                $.each(data, function (key, value) {
                    message += value + '</br>';
                });
                message += '</div>';
                $('form[name="employeeUpdateForm"]').parent().find('.form-errors').html(message);
                setTimeout(function(){
                  //  window.location.reload();
                }, 3000);
            },
            error: function (data) {
                var errorsHtml = '<div class="alert alert-danger"><ul>';
                $.each(data.responseJSON, function (key, value) {
                    errorsHtml += '<li>' + value + '</li>';
                });
                errorsHtml += '</ul></div>';
                $('form[name="employeeUpdateForm"]').parent().find('.form-errors').html(errorsHtml);
            }
        });
    });
});