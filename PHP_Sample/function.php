<?php 
    // koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "phpdasar");

    function query($query) {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function tambah($data){
        global $conn;
        $nrp = htmlspecialchars($data["nrp"]);
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $jurusan = htmlspecialchars($data["jurusan"]);
        
        // upload gambar
        $gambar = upload();
        if (!$gambar) {

            return false;
        }

        // insert into database
        $query = "INSERT INTO mahasiswa VALUES 
                    ('', '$nrp', '$nama', '$email', '$jurusan', '$gambar')";

        mysqli_query($conn, $query);

        if (mysqli_affected_rows($conn) > 0) {
            echo "berhasil";
        } else {
                echo "gagal!";
                echo "<br>";
                echo mysqli_error($conn);
        }
    }

    function upload() {
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        // cek apakah tidak ada gambar yang diupload, 4-> tidak ada gambar yang diupload
        if ($error === 4) {
            echo "<script>
                    alert('Pilih gambar terlebih dahulu!');
                  </script>";
            return false;
        }

        // cek apakah yang diupload hanya gambar
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        // kalau tidak ada masukan ekstensi yang valid, munculkan sebuah pesan
        if( !in_array($ekstensiGambar, $eksetensiGambarValid)) {
            echo "<script>
                    alert('yang anda upload bukan gambar')
                  </script>";
            return false;
        }

        // cek jika ukurannya terlalu besar, values in byte 
        if ($ukuranFile > 1000000) {
            echo "<script>
                    alert('ukuran gambar terlalu besar')
                  </script>";
            return false;
        }

        // gambar lolos pengecekan, siap diupload
        // generate gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        /* check out $namaFileBaru
        var_dump($namaFileBaru);
        die;
        */

        move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
        
        return $namaFileBaru;
    }

    function ubah($data) {
        global $conn;

        $id = $data["id"];
        $nrp = htmlspecialchars($data["nrp"]);
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $jurusan = htmlspecialchars($data["jurusan"]);
        $gambarLama = htmlspecialchars($data["gambarLama"]);

        // cek apakah user pilih gambar baru atau tidak
        if ($_FILES['gambar']['error'] === 4) {
            $gambar = $gambarLama;
        } else {
            $gambar = upload();
        }

        $gambar = htmlspecialchars($data["gambar"]);

        $query = "UPDATE mahasiswa SET
                    nrp = '$nrp',
                    nama = '$nama',
                    email = '$email',
                    jurusan = '$jurusan',
                    gambar = '$gambar'
                  WHERE id = $id; 
                    ";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);

    }

    function hapus($id) {
        global $conn;

        mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

        return mysqli_affected_rows($conn);
    }

    function cari($keyword) {
        $query = "SELECT * FROM mahasiswa WHERE 
                    nama LIKE '%$keyword%' OR
                    nrp LIKE '%$keyword%' OR
                    email LIKE '%$keyword%' OR
                    jurusan LIKE '%$keyword%'
                    ";
        return query($query);

        // ambil data (fetch) mahasiswa dari object result
        // mysqli_fetch_row() mengembalikan array numerik
        // mysqli_fetch_assoc() mengembalikan array associative
        // mysqli_fetch_array() mengembalikan array numerik & associative
        // mysqli_fetch_object()
        // fetch_object() example: var_dump($mhs -> nama)
    }

    // function registrasi
    // fungsi stripslahes bersihkan inputan backslash atau slash
    // mysqli_real_escape_string memungkinkan user masukan input yang mempunyai tanda kutip
    function registrasi($data){
        global $conn;
        
        $username = strtolower(stripslashes($data["username"]));
        /*
        $password = $conn -> real_escape_string($data["password"]);
        $password2 = $conn -> real_escape_string($data["password2"]);
        */

        $password = mysqli_real_escape_string($conn, $data['password']);
        $password2 = mysqli_real_escape_string($conn, $data['password2']); 

        // cek user lama sudah ada atau belum
        $result = mysqli_query($conn, "SELECT username FROM user WHERE username LIKE '$username' ");
        
        // then, fetch the result to see if the result return true value
        if (mysqli_fetch_assoc($result)) {
            echo "<script>
                    alert('username sudah terdaftar');
                    </script>";
            return false;
        }

        // cek konfirmasi password dengan password2
        if ($password !== $password2) {
            echo "<script>
                    alert('konfirmasi pasword tidak sesuai');
                  </script>";

            return false;
            
        } 

        // sebelum user ditambahkan, enkripsikan password terlebih dahulu, 
        // disarankan untuk password gunakan hash dibandingkan dengan MD5
        // for md5 -> md5($password);
        // use password_hash(the encripted password, hash_algorithm)
        $password = password_hash($password, PASSWORD_DEFAULT);

        // kalau password sama, insert user baru ke database
        mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password', '$password2')");
        return mysqli_affected_rows($conn);
        
        

    }