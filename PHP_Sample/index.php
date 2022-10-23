<?php 

session_start();

// check apakah user sudah login atau belum berdasarkan session
if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// pagination
// konfigurasi
// $jumlahDataPerHalaman = 2;

// count menghitung seluruh data untuk array associatif ;
// $jumlahData = count(query("SELECT * FROM mahasiswa"));

// hitung jumlah halaman yang ditujukan
// $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

// menentukan halaman yang sedang aktif
// jika halaman masih belum ada, tambahkan kondisi parameter baru
// kalau halaman ada isi, data diambil dari URL
/* kalau pake if
if(isset($_GET["halaman"])){
    $halamanAktif = $_GET["halaman"];
} else {
    $halamanAktif = 1;
}*/

// if condition di atas bisa disingkatkan via ternary operator
// $halamanAktif = ( isset($_GET["halaman"])) ? $_GET["halaman"] : 1;

// via menangkap nilai di url
// $halamanAktif = $_GET["halaman"];


/*
NOTE: round -> pembulatan biasa (1.5 ke atas)
      ceil -> pembulatan ke atas
      floor -> pembulatan ke bawah
*/

// konfigurasi pagination
$jumlahDataPerHalaman = 4;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;

// the formula for the total result of the pagination
// halaman pertama, mulai dari index 0
// halaman kedua, mulai dari index 1
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// $mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id ASC");
$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");


/* tombol cari ditekan */
if(isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Admin</title>
    <style>
        .loader {
            width: 100px;
            position: absolute;
            top: 120px;
            z-index: -1;
            left: 210px;
            display: none;
        }
    </style>

<body>

<a href = "logout.php">Logout</a>

<h1>Daftar Mahasiswa</h1>

<a href = "tambah.php">Tambah Data Mahasiswa</a>

<br/>

<br/>

<div id = "container">

    <table border = "1" cellpadding = "10" cellspacing = "0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NRP</th>
            <th>Email</th>
            <th>Nama</th>
        </tr>
        <!-- simplest form of inserting php database 
        <?php // $i = 1 ?>
        <?php // while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td>
                <a href = "">ubah</a>
                <a href = "">hapus</a>
            </td>
            <td><img src = "img/<?= // $row["gambar"]?>" width = "50" ></td>
            <td><?= // $row["nrp"] ?></td>
            <td><?= // $row["nama"] ?></td>
            <td><?= // $row["email"] ?></td>
            <td><?= // $row["jurusan"] ?></td>
        </tr>
        <?php // $i++; ?>
        <?php // endwhile; ?>
        -->

        <!-- more sensible way to implement this sort of rows insertion -->
        <?php $i = 1 ?>
        <?php foreach($mahasiswa as $row) : ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td>
                <a href = "ubah.php?id=<?=$row["id"]?>">ubah</a>
                <a href = "hapus.php?id=<?= $row["id"];?>"
                    onclick = "return confirm('yakin?');">hapus</a>
            </td>
            <td><img src = "img/<?= $row["gambar"];?>" width = "50" ></td>
            <td><?= $row["nrp"] ?></td>
            <td><?= $row["nama"] ?></td>
            <td><?= $row["email"] ?></td>
            <td><?= $row["jurusan"] ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>

</div>

<!-- Live Search Function Using JQuery -->
<script src = "js/jquery-3.6.1.min.js"></script>

<!-- Live Search Function inside javascript -->
<script src = "js/script.js"></script>

<!-- search function -->
<form action = "" method = "post"> 

    <input type = "text" name = "keyword" size = "40" autofocus
        placeholder = "masukkan keyword pencarian" autocomplete = "off" id="keyword">
    <button type = "submit" name = "cari" id="tombol-cari">Cari!</button>

    <img src="img/loader.gif" class="loader">

</form>

<!-- form navigasi 1, 2 for pagination -->

<!-- adding arrow for navigation -->

<!-- tambah fitur back pada  halaman aktif apabila tombol arrow left ditekan,
    munculkan arrow apabila halaman aktif lebih dari 1 -->
<?php if ($halamanAktif > 1) : ?>
    <a href = "?halaman=<?$halamanAktif - 1;?>">&laquo</a>
<?php endif; ?>

<?php for($i = 1; i <= $jumlahHalaman; $i++) : ?>
    <!-- adding indicator for current active page -->
    <?php if($i == $halamanAktif) : ?>
            <a href = "?halaman=<?$i;?>" style="font-weight: bold; color: red;"><?= $i; ?></a>
        <?php else : ?>
            <a href = "?halaman=<?$i;?>"><?= $i; ?></a>
    <?php endif; ?>
<?php endfor ?>

<!-- tambahkan tombol next -->
<?php if ($halamanAktif < $jumlahHalaman) : ?>
    <a href = "?halaman=<?$halamanAktif + 1;?>">&raquo</a>
<?php endif; ?>

</br>

</body>

</html>



