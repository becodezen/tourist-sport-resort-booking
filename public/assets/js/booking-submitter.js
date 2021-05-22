/*
* Ajax Form Submitter
* @SweetAlert must have to include
*/
bookingSubmit = function (t, e) {
    const form = $(t).parents('form');
    const action = $(form).attr('action');
    const method = $(form).attr('method');
    const mime = $(form).attr('enctype');
    const btn = $(t).html();

    $(form).one('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: action,
            type: method,
            beforeSend: function () {
                $(t).attr('disabled', 'disabled');
                $('.has-error').find('.text-danger').text('');
                $('.form-control').parent('.has-error').removeClass('has-error');
                $(t).children().html('<i class="fa fa-spinner fa-spin"></i>');
            },
            data: formData,
            processData: false,
            contentType: false,
            mimeType: mime,
            dataType: 'JSON',
            xhr: function () {
                //upload Progress
                let xhr = new window.XMLHttpRequest();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function (event) {
                        //console.log(event);
                        let percent = 0;
                        let position = event.loaded || event.position;
                        let total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //update progressbar
                        // bar.css("width", +percent + "%");
                        //$(progress_bar_id + " .status").text(percent +"%");
                    }, true);
                }
                return xhr;
            },
        }).done(function (ret) {
            // console.log(ret);
            let type = ret.type;
            let title = ret.title;
            if (ret.type == 'success') {
                $(form)[0].reset();
                $('#roomList').html('');
                $('#room_info_check_in').html('');
                $('#room_info_check_out').html('');
                $('#sub_total').val(null);
                $('#grand_total').val(null);
                $('#verified').attr('id', 'verifyPhone').html('Verify');
                $('#guestPhone').prop('readonly', false);
                $('#guestBookingSubmit, #bookNowModalBtn').prop('disabled', true);
            }

            Swal.fire({
                title: title,
                text: ret.message,
                icon: type,
                timer: 5000,
            }).then(function (res) {
                if (ret.redirect && res) {
                    redirect(ret.redirect);
                }
            }, function (dismiss) {
                if (ret.redirect && dismiss === 'timer') {
                    redirect(ret.redirect);
                }
            });

        })
            .fail(function (res) {
                // errors = JSON.parse(res.responseText);
                errors = res.responseJSON['errors'];
                console.log(errors);
                // console.log(res.responseText);
                if (errors) {
                    $.each(errors, function (index, error) {
                        $("[name=" + index + "]").parents('.form-group').find('.text-danger').text(error);
                        $("[name=" + index + "]").parent().addClass('has-error');
                        $(form).find("." + index).text(error);
                    });
                }
            })
            .always(function () {
                $(t).removeAttr('disabled');
                $(t).html(btn);
                // console.log('complete');
                // progress.fadeOut(300);
            });
    });
};

/**
 * Redirect to given url
 * @param $url
 * @returns {boolean}
 */
function redirect($url) {
    setTimeout(function () {
        window.location.href = $url;
    }, 200);
    return true;
}
