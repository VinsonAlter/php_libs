<?php
    session_start();
    // boleh ditimpahkan satu array kosong juga
    $_SESSION = [];
    // tambahkan session_unset() biar sesi bisa hilang sepenuhnya
    session_unset();
    session_destroy();

    // hapus cookie setelah logout
    setcookie('id', '', time() - 3600);
    setcookie('key', '', time() - 3600);

    header("Location: login.php");
    exit;
?>