<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location:login.php");
    exit;
}
require("functions.php");

if (isset($_POST["submit"])) {

    if (tambah($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Ditambakan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "<script>
        alert('Data Gagal Ditambakan!');
        document.location.href = 'index.php';
    </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Buku</title>
</head>

<body>

    <h1>Tambah Data Buku</h1>

    <form action="" method="post" enctype="multipart/form-data">

        <ul style="list-style: none;">
            <li style=" margin: 5px 0">
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul">
            </li>
            <li style=" margin: 5px 0">
                <label for="pengarang">Pengarang</label>
                <input type="text" name="pengarang" id="pengarang">
            </li>
            <li style=" margin: 5px 0">
                <label for="tahun_terbit">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" id="tahun_terbit">
            </li>
            <li style=" margin: 5px 0">
                <label for="penerbit">Penerbit</label>
                <input type="text" name="penerbit" id="penerbit">
            </li>
            <li style=" margin: 5px 0">
                <label for="penerbit">Gambar</label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <button type="submit" name="submit">Simpan</button>
        </ul>

    </form>

</body>

</html>