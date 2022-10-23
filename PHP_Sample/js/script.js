// ambil elemen2 yang dibutuhkan via teknik penelusuran DOM
var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

// tambahkan event ketika keyword ditulis -> keypress ketika key input sesuatu, bisa keypress atau keyup
keyword.addEventListener('keyup', function() {
    // console.log(keyword.value); -> ambil value keyword yang diketikkan di search

    // buat object ajax
    var xhr = new XMLHttpRequest();

    // cek kesiapan ajax -> onreadystatechange, readystate range from 0 to 4, 4 is the source ready
    // status = 200, status ok, 404 == source not found
   
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // console.log(xhr.responseText);
            // xhr.responseText berisi apapun dari sumbernya, jadi coba.txt dimasukkan ke responseText
            
            // ganti isi tabel dari kolom search
            container.innerHTML = xhr.responseText;
        }
    }

    // eksekusi ajax, first parameter get or post, second the files name, third select true if async else
    // false
    xhr.open('GET', 'ajax/mahasiswa.php?keyword=' + keyword.value, true);
    // jalankan ajax
    xhr.send();

});