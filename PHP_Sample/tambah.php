<?php
    $conn = mysqli_connect("localhost", "root", "", "phpdasar");

    require 'function.php';
    /* cek apakah tombol submit sudah ditekan atau belum */
    if(isset($_POST["submit"])) {

        /* to see post content
        var_dump($_POST); die;
        var_dump($_FILES); die;
        */
        
        if (tambah ($_POST) > 0) {
            echo "
                <script>
                    alert('Data berhasil ditambahkan');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Data gagal ditambahkan');
                    document.location.href = 'index.php';
                </script>
            ";
        }
    }
?>

<!-- cek apakah data sudah disubmit atau belum - prototype
<?php
/*
    if(isset($_POST["submit"])) {
        // ambil data dari tiap elemen di kolum
        $nrp = $_POST["nrp"];
        $nama = $_POST["nama"];
        $email = $_POST["email"];
        $jurusan = $_POST["jurusan"];
        $gambar = $_POST["gambar"];

        // query insert data
        $query = "INSERT INTO mahasiswa VALUES
                    ('', '$nrp', '$nama', '$email', '$jurusan', '$gambar')
                ";
        mysqli_query($conn, $query);

        // cek apakahh data berhasil ditambahkan atau tidak
        // var_dump(mysqli_affected_rows($conn));

        if (mysqli_affected_rows($conn) > 0) {
            echo "berhasil";
        } else {
            echo "gagal";
            echo "<br>";
            echo mysqli_error($conn);
        }
    }   
    */
?>
-->

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Mahasiswa</title>
</head>
<body>
    <h1>Tambah data mahasiswa</h1>

    <form action = "" method = "post" enctype = "multipart/form-data">
        <ul>
            <li>
                <label for = "nrp">NRP: </label>
                <input type = "text" name = "nrp" id = "nrp" required>
            </li>
            <li>
                <label for = "nama">Nama: </label>
                <input type = "text" name = "nama" id = "nama">
            </li>
            <li>
                <label for = "nama">Email: </label>
                <input type = "text" name = "nama" id = "nama">
            </li>
            <li>
                <label for = "jurusan">Jurusan: </label>
                <input type = "text" name = "jurusan" id = "jurusan">
            </li>
            <li>
                <label for = "gambar">Gambar: </label>
                <input type = "file" name = "gambar" id = "gambar">
            </li>
            <li>
                <button type = "submit" name = "submit">Tambah Data!</button>
            </li>
        </ul>

    </form>
</body>
</html>