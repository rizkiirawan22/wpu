<?php
$host = "localhost";
$username = "root";
$pass = "";
$db = "db_wpu";
$conn = mysqli_connect($host, $username, $pass, $db);

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function cari($keyword)
{
    $query = "SELECT * FROM tbl_buku
                WHERE
                judul LIKE '%$keyword%' OR
                pengarang LIKE '%$keyword%' OR
                tahun_terbit LIKE '%$keyword%' OR
                penerbit LIKE '%$keyword%'
                ";
    return query($query);
}



function tambah($data)
{
    global $conn;
    $judul = htmlspecialchars($data["judul"]);
    $pengarang = htmlspecialchars($data["pengarang"]);
    $tahun = htmlspecialchars($data["tahun_terbit"]);
    $penerbit = htmlspecialchars($data["penerbit"]);

    //Upload Gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO tbl_buku
                VALUES
            ('', '$judul', '$pengarang', '$tahun', '$penerbit', '$gambar' )
            ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload()
{

    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpname = $_FILES['gambar']['tmp_name'];

    //Cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
                alert('pilih gambar terlebih dahulu');
                </script>";
        return false;
    }

    //cel apakah yang diupload gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('yang diupload bukan gambar');
                </script>";
        return false;
    }

    //cek jika ukuran terlalu besar
    if ($ukuranfile > 5000000) {
        echo "<script>
                alert('ukuran gambar terlalu besar');
                </script>";
        return false;
    }

    //lolos pengecekan, siap diupload
    //generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpname, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function ubah($data)
{
    global $conn;
    $id = $data["idhide"];
    $judul = htmlspecialchars($data["judul"]);
    $pengarang = htmlspecialchars($data["pengarang"]);
    $tahun = htmlspecialchars($data["tahun_terbit"]);
    $penerbit = htmlspecialchars($data["penerbit"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    //cek memilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }
    $query = "UPDATE tbl_buku
                SET
                judul = '$judul',
                pengarang = '$pengarang',
                tahun_terbit = '$tahun',
                penerbit = '$penerbit',
                gambar = '$gambar'
                WHERE id = '$id'";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tbl_buku WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password_konfir = mysqli_real_escape_string($conn, $data["password_konfir"]);

    //Cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM tbl_user WHERE
                        username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo " <script>
                alert('Username Sudah Terdaftar');
                </script>";
        return false;
    }

    //Cek Konfirmasi Password
    if ($password !== $password_konfir) {
        echo "<script>
                alert('Password Yang Dimasukkan Tidak Sesuai');
                </script>";
        return false;
    }
    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    //insert ke database
    mysqli_query($conn, "INSERT INTO tbl_user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}
