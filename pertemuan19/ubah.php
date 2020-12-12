<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location:login.php");
    exit;
}
require("functions.php");

$id = $_GET["id"];
$buku = query("SELECT * FROM tbl_buku WHERE id = $id")[0];


if (isset($_POST["ubah"])) {

    if (ubah($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Diubah!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Diubah!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Buku</title>
</head>

<body>

    <h1>Ubah Data Buku</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idhide" value="<?= $buku["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $buku["gambar"]; ?>">
        <ul style="list-style: none;">
            <li style=" margin: 5px 0">
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" value="<?= $buku["judul"]; ?>">
            </li>
            <li style=" margin: 5px 0">
                <label for="pengarang">Pengarang</label>
                <input type="text" name="pengarang" id="pengarang" value="<?= $buku["pengarang"]; ?>">
            </li>
            <li style=" margin: 5px 0">
                <label for="tahun_terbit">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" id="tahun_terbit" value="<?= $buku["tahun_terbit"]; ?>">
            </li>
            <li style=" margin: 5px 0">
                <label for="penerbit">Penerbit</label>
                <input type="text" name="penerbit" id="penerbit" value="<?= $buku["penerbit"]; ?>">
            </li>
            <li style=" margin: 5px 0">
                <label for="penerbit">Gambar</label><br>
                <img src="img/<?= $buku["gambar"]; ?>" width="100" alt=""><br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <button type="submit" name="ubah">Simpan</button>
        </ul>

    </form>

</body>

</html>