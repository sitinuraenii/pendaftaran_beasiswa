<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "beasiswa";

$koneksi = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $koneksi; 
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $phone = htmlspecialchars($data['phone']);
    $semester = htmlspecialchars($data['semester']);
    $ipk = htmlspecialchars($data['ipk']);
    $beasiswa = htmlspecialchars($data['beasiswa']);
    $status = htmlspecialchars($data['status']);
    $berkas = htmlspecialchars($data['berkas']);
    $query = "INSERT INTO pendaftar (nama, email, phone, semester, ipk, beasiswa, status, berkas) VALUES ('$nama', '$email', '$phone', '$semester', '$ipk', '$beasiswa', '$status', '$berkas')";

    if (mysqli_query($koneksi, $query)) {
        return mysqli_affected_rows($koneksi);
    } else {
        echo "Error: " . mysqli_error($koneksi);
        return 0;
    }
}

?>
