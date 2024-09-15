<?php
include 'function.php'; 

$id = $_GET['id'];

$sql = "DELETE FROM pendaftar WHERE id=$id";

if ($koneksi->query($sql) === TRUE) {
    header("Location: hasil.php");
} else {
    echo "Error deleting record: " . $koneksi->error;
}

$koneksi->close();

header("Location: hasil.php");
?>