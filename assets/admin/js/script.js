$(function() {

	$("#form-tambah").validate({
		rules: {
			nama: {
				required: true
			},
			harga: {
				required: true,
				number: true
			},
			qty: {
				number: true
			},
			status: {
				required: true
			}
		},
		messages: {
			nama: {
				required: 'Kolom nama harus diisi!'
			},
			harga: {
				required: 'Kolom harga harus diisi!',
				number: 'Harus angka!'
			},
			qty: {
				number: 'Harus angka!'
			},
			status: {
				required: 'Status harus dipilih!'
			}
		}
	});

	$("#form-tambah-pembayaran").validate({
		rules: {
			tipe: {
				required: true
			},
			nama: {
				required: true
			},
			deskripsi: {
				required: true
			},
			vendor: {
				required: true
			},
			status: {
				required: true
			},
			urutan: {
				required: true,
				number: true
			}
		},
		messages: {
			tipe: {
				required: 'Kolom tipe harus diisi!'
			},
			nama: {
				required: 'Nama harus diisi!'
			},
			deskripsi: {
				required: 'Deskripsi harus diisi!'
			},
			vendor: {
				required: 'Vendor harus diisi!'
			},
			status : {
				required: 'Status harus diisi!'
			},
			urutan: {
				required: 'Urutan harus diisi!',
				number: 'Urutan harus angka!'
			}
		}
	});

	let flashData = $(".flash-data").data('flashdata');

	if(flashData) {
		Swal.fire({
			type: 'success',
			title: 'Sukses',
			text: flashData
		});
	}

	$(".hapus").on('click', function(e){
		e.preventDefault();

		let linkHref = $(this).attr('href');

		Swal.fire({
			title: 'Apakah ingin dihapus?',
			text: "Data yang dihapus tidak dapat dikembalikan lagi!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya hapus!',
			cancelButtonText: 'Jangan!'
		}).then((result) => {
			if (result.value) {
				document.location.href = linkHref;
			}
		})

	});

	// skrip untuk ngakalin file upload bootstrap
	$('.custom-file-input').on('change', function () {
		let file_name = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass("selected").html(file_name);
	});

	$(".tombol-edit-tipe").on('click', function() {

		let id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/shop/admin/pembayaran/get_tipe',
			method: 'post',
			data: {id: id},
			dataType: 'json'
		}).done(function(data) {
			$("#edit_tipe").val(data.nama);
			$("#id_tipe").val(data.id);
		});

	});

	$('.input-number').on('keydown', function(event) {
        return ( event.ctrlKey || event.altKey 
            || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
            || (95<event.keyCode && event.keyCode<106)
            || (event.keyCode==8) || (event.keyCode==9) 
            || (event.keyCode>34 && event.keyCode<40) 
            || (event.keyCode==46) )
    })

	$('input.price-format').keyup(function(event) {

		// skip for arrow keys
		if(event.which >= 37 && event.which <= 40) return;
	  
		// format number
		$(this).val(function(index, value) {
		  return value
		  .replace(/\D/g, "")
		  .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
		  ;
		});
	  });

});

function deleteRow(event, $this) {
	event.preventDefault();
	const url = $($this).attr('href')
	console.log(url)
}