function changeThumbnail(event) {
    const file = event.target.files[0]
    if (file) {
        const fsize = file.size
        const size = Math.round((fsize / 1024));
        if (size > 2048) {
            Swal.fire({
                type: 'error',
                title: lang['alert'],
                html: 'Gambar terlalu besar!'
            })
            return false
        } else {
            const reader = new FileReader()
            reader.onloadend = () => {
                const base64String = reader.result.replace("data:", "").replace(/^.+,/, "");
                $('input[name=thumbnail]').val(base64String)
                let html = '';
                html += '<div class="d-inline-block">'
                    html += '<img class="img-thumbnail image-cover-fit" src="' + reader.result + '" />'
                html += '</div>'
                html += '<div class="d-inline-block ml-3">'
                    html += '<button class="btn btn-danger btn-sm mt-3" type="button" onclick="deleteThumbnail()">' + lang['delete'] + '</button>';
                html += '</div>'
                $('#image_cover').html(html)
            }
            reader.readAsDataURL(file)
        }
    }
}

function changeImages(event) {
    const file = event.target.files[0]
    if (file) {
        const fsize = file.size
        const size = Math.round((fsize / 1024));

        if (size > 2048) {
            Swal.fire({
                type: 'error',
                title: lang['alert'],
                html: 'Gambar terlalu besar!'
            })
            return false
        } else {
            const reader = new FileReader()
            reader.onloadend = () => {
                const base64String = reader.result.replace("data:", "").replace(/^.+,/, "");
                const images_child = document.getElementsByClassName('images-child')
                let html = '';
                if (images_child.length > 0) {
                    let idNumber = 1
                    for(let i = 0; i < images_child.length; i++) {
                        const id_element = images_child[i].id
                        const base64Value = images_child[i].getAttribute('data-base64')
                        const readerResult = images_child[i].getAttribute('data-reader')
                        
                        html += '<div class="col-sm-2 mb-3">'
                            html += '<div class="images-child" id="' + id_element + '" data-base64="' + base64Value + '" data-reader="' + readerResult + '">'
                                html += '<img src="' + readerResult + '" class="img-thumbnail image-cover-fit" />'
                                html += '<a href="javascript:void(0)" class="button-delete-images" onclick="deleteImages(\'' + id_element + '\')"><i class="fas fa-times"></i></a>'
                                html += '<input type="hidden" name="images[]" class="product-images" value="' + base64Value + '" />'
                            html += '</div>'
                        html += '</div>'
        
                        idNumber++
                    }
                    html += '<div class="col-sm-2 mb-3">'
                        html += '<div class="images-child" id="image-child-' + (idNumber) + '" data-base64="' + base64String + '" data-reader="' + reader.result + '">'
                            html += '<img src="' + reader.result + '" class="img-thumbnail image-cover-fit" />'
                            html += '<a href="javascript:void(0)" class="button-delete-images" onclick="deleteImages(\'image-child-' + (idNumber) + '\')"><i class="fas fa-times"></i></a>'
                            html += '<input type="hidden" name="images[]" class="product-images" value="' + base64String + '" />'
                        html += '</div>'
                    html += '</div>'
                } else {
                    html += '<div class="col-sm-2 mb-3">'
                        html += '<div class="images-child" id="image-child-1" data-base64="' + base64String + '" data-reader="' + reader.result + '">'
                            html += '<img src="' + reader.result + '" class="img-thumbnail image-cover-fit" />'
                            html += '<a href="javascript:void(0)" class="button-delete-images" onclick="deleteImages(\'image-child-1\')"><i class="fas fa-times"></i></a>'
                            html += '<input type="hidden" name="images[]" class="product-images" value="' + base64String + '" />'
                        html += '</div>'
                    html += '</div>'
                }
                html += '<div class="col-sm-2 mb-3">'
                    html += '<div style="height: 180px;">'
                        html += '<button class="btn btn-block btn-outline-dark btn-add-images" style="height:100%;" type="button" onclick="openModalImage(event)">+</button>'
                    html += '</div>'
                html += '</div>'
                $('.images-cover').html(html)
            }
            reader.readAsDataURL(file)
        }

    }
}

function openModalImage() {
    document.getElementById('attach_images').click()
}

function deleteThumbnail() {
    Swal.fire({
        title: lang['alert'],
        html: 'Apakah ingin dihapus?',
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: lang['yes'],
        cancelButtonText: lang['cancel']
    }).then(result => {
        if (result.value) {
            const html = '<input type="file" id="thumbnail" accept="image/*" onchange="changeThumbnail(event)">';
            $('#image_cover').html(html)
            $('input[name=thumbnail]').val('')
        }
    })
}

function deleteImages(id) {
    Swal.fire({
        title: lang['alert'],
        html: 'Apakah ingin dihapus?',
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: lang['yes'],
        cancelButtonText: lang['cancel']
    }).then(result => {
        if (result.value) {
            const element = document.getElementById(id).parentElement;
            element.remove()
        }
    })
}

function save_product(event, $this) {
    event.preventDefault()
    const url = $($this).attr('action')
    const method = $($this).attr('method')

    $("#submit").text('Memuat...')
    $("#submit").attr('disabled', true)

    $.ajax({
        url: url,
        method: method,
        data: {
            name: $('input[name=name]').val(),
            price: $('input[name=price]').val(),
            category: $('select[name=category]').val(),
            stock: $('input[name=stock]').val(),
            seo_url: $('input[name=seo_url]').val(),
            weight: $('input[name=weight]').val(),
            thumbnail: $('input[name=thumbnail]').val(),
            images: $("input[name='images[]']").map(function(){return $(this).val();}).get(),
            status: $('select[name=status]').val(),
            description: $('textarea[name=description]').val()
        },
        success: function(data) {
            data = JSON.parse(data)
            $("#submit").text(lang['save'])
            $("#submit").removeAttr('disabled')
            if (data.status == 'success') {
                Swal.fire({
                    type: 'success',
                    html: data.message,
                    title: lang['alert'],
                }).then(res => {
                    window.location.href = site_url + 'product'
                })
            } else {
                Swal.fire({
                    type: 'error',
                    html: data.message,
                    title: lang['alert']
                })
            }
        },
        error: function() {
            $("#submit").text(lang['save'])
            $("#submit").removeAttr('disabled')
            Swal.fire({
                type: 'error',
                html: "Terjadi suatu kesalahan!",
                title: lang['alert']
            })
        }
    })
}