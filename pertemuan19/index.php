<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location:login.php");
    exit;
}

require("functions.php");

$data = query("SELECT * FROM tbl_buku");
if (isset($_POST["cari"])) {
    $tampil = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
</head>

<body>

    <a href="logout.php">Logout</a>

    <h1>Daftar Buku</h1>

    <a href="tambah.php">Tambah Data</a>
    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun Terbit</th>
            <th>Penerbit</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($data as $row) : ?>
            <tr>
                <td><?= $row["judul"]; ?></td>
                <td><?= $row["pengarang"]; ?></td>
                <td><?= $row["tahun_terbit"]; ?></td>
                <td><?= $row["penerbit"]; ?></td>
                <td><img style="width: 100px;" src="img/<?= $row["gambar"]; ?>" alt=""></td>
                <td>
                    <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin?')">Delete</a>
                    <a href="ubah.php?id=<?= $row["id"]; ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>