<?php
    session_start();

    if(!isset($_SESSION["login"])) {
        header("Location:login.php");
        exit;
    }

    $conn = mysqli_connect("localhost", "root", "", "phpdasar");

    require 'function.php';

    // ambil data di URL 
    $id = $_GET["id"];

    // query data mahasiswa berdasarkan id
    $mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

    // to check the query
    var_dump($mhs["nrp"]);

    /* in order to var dump query data like for example 'nrp' label in database
    var_dump($mhs[0]["nrp"]);
    */

    /* cek apakah data berhasil diubah */
    if(isset($_POST["submit"])) {
        
        if (ubah($_POST) > 0) {
            echo "
                <script>
                    alert('Data berhasil diubah');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Data gagal diubah');
                    document.location.href = 'index.php';
                </script>
            ";
        }
    }
?>



<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data Mahasiswa</title>
</head>
<body>
    <h1>Ubah data mahasiswa</h1>

    <form action = "" method = "post" enctype = "multipart/form-data">
        <ul>
            <li>
                <input type = "hidden" name = "id" required
                    value = "<?=$mhs["id"]?>">
                <input type = "hidden" name = "gambarLama" 
                    value = "<?=$mhs["gambar"]?>">
            </li>
            <li>
                <label for = "nrp">NRP: </label>
                <input type = "text" name = "nrp" id = "nrp" required
                    value = "<?= $mhs["nrp"]; ?>">
            </li>
            <li>
                <label for = "nama">Nama: </label>
                <input type = "text" name = "nama" id = "nama"
                    value = "<?=$mhs["nama"]; ?>">
            </li>
            <li>
                <label for = "email">Email: </label>
                <input type = "text" name = "email" id = "email"
                    value = "<?=$mhs["email"]?>">
            </li>
            <li>
                <label for = "jurusan">Jurusan: </label>
                <input type = "text" name = "jurusan" id = "jurusan"
                    value = "<?=$mhs["jurusan"]?>">
            </li>
            <!-- Tampilkan gambar yang sudah ditambah untuk diubah -->
            <li>
                <label for = "gambar">Gambar: </label> <br/>
                <img src = "img/<?=$mhs["gambar"]; ?>" 
                    width = "40" > <br/>
                <input type = "file" name = "gambar" id = "gambar">
            </li>
            <li>
                <button type = "submit" name = "submit">Ubah Data!</button>
            </li>
        </ul>

    </form>
</body>
</html>