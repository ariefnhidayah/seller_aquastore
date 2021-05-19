$(function() {
    $('#province').on('change', function(event) {
        const province_id = $(this).val()
        $('#city').html('<option value="">Select City</option>')
        $('#district').html('<option value="">Select District</option>')

        $.ajax({
            url: site_url + 'auth/get_cities',
            method: "post",
            data: {
                province_id: province_id
            },
            success: function(data) {
                data = JSON.parse(data)
                let html = '<option value="">Select City</option>';
                for(let i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].id + '">' + data[i].type + ' ' + data[i].name + '</option>';
                }
                $('#city').html(html)
            }
        })
    })

    $('#city').on('change', function(event) {
        const city_id = $(this).val()
        $('#district').html('<option value="">Select District</option>')

        $.ajax({
            url: site_url + 'auth/get_districts',
            method: "POST",
            data: {
                city_id: city_id,
            },
            success: function(data) {
                data = JSON.parse(data)
                let html = '<option value="">Select District</option>';
                for(let i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                }
                $('#district').html(html)
            }
        })
    }) 
})