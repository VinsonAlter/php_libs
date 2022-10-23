$(document).ready(function() {

    // hide tombol cari via jquery
    $('#tombol-cari').hide();
    
    // event ketika keyword ditulis

    // load cuma bisa digunakan pada GET saja 
    $('#keyword').on('keyup', function() {
        // munculkan icon loading saat keyup
        $('.loader').show();

        // ajax menggunakan load
        // $('#container').load('ajax/mahasiswa.php?keyword=' + $('#keyword').val());

        // $.get(), data berfungsi menggantikan xhr.responseText
        $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data) {
            $('#container').html(data);
            $('.loader').hide();
        });
    })
})