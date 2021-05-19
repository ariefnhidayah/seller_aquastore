$(function() {
    $('#resend_code').on('click', function(e) {
        $(this).html('Loading...')
        $(this).attr('disabled', true)

        $.ajax({
            url: site_url + 'profile/resend_code',
            success: function(data) {
                data = JSON.parse(data)
                if (data.status == 'success') {
                    Swal.fire({
                        title: 'Notice!',
                        type: 'success',
                        html: data.message
                    })
                    countdown(120)
                } else if (data.status == 'delay') {
                    Swal.fire({
                        title: 'Warning!',
                        type: 'warning',
                        html: data.message
                    })
                    countdown(120)
                } else {
                    Swal.fire({
                        title: 'Warning!',
                        type: 'error',
                        html: data.message
                    })
                    $('#resend_code').html('Kirim Ulang')
                    $('#resend_code').removeAttr('disabled')
                }
            }
        })
    })
})

function countdown(second) {
    let interval = setInterval(function() {
        second--
        if (second <= 0) {
            clearInterval(interval);
            $('#resend_code').html('Kirim Ulang')
            $('#resend_code').removeAttr('disabled')
        } else {
            $('#resend_code').html(`Tunggu ${second}s`)
            $('#resend_code').attr('disabled', true)
        }
    }, 1000)
}