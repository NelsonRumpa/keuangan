src="https://code.jquery.com/jquery-3.6.0.min.js"

$(document).ready(function() {
    // Handle click event on "Simpan" button inside the modal
    $('.save-button').on('click', function() {
        var formId = $(this).data('formid');
        var formData = $('#' + formId).serialize();
        
        // Kirim permintaan ke server (menggunakan AJAX atau sesuai kebutuhan)
        $.ajax({
            type: 'POST',
            url: $('#' + formId).attr('action'),
            data: formData,
            success: function(response) {
                // Proses respons dari server sesuai kebutuhan
                // Misalnya, tutup modal atau tampilkan pesan sukses
                alert('Data berhasil diubah.');
                $('#edit-modal-' + formId).modal('hide');
            },
            error: function(error) {
                // Proses error sesuai kebutuhan
                alert('Terjadi kesalahan saat mengubah data.');
            }
        });
    });
});