<?php
require 'function.php';
require 'navbar.php';
$nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
$semester = isset($_GET['semester']) ? $_GET['semester'] : '';
$ipk = isset($_GET['ipk']) ? $_GET['ipk'] : '';
$beasiswa = isset($_GET['beasiswa']) ? $_GET['beasiswa'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : 'Belum diverifikasi';
$berkas = isset($_GET['berkas']) ? $_GET['berkas'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h1 class="mb-4 pt-4 mt-5 text-center">Hasil Pendaftar</h1>
    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th>Semester</th>
                    <th>IPK terakhir</th>
                    <th>Beasiswa</th>
                    <th>Status</th>
                    <th>berkas</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pendaftar = query("SELECT * FROM pendaftar");
                $no = 1;
                foreach($pendaftar as $p) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($p['nama']); ?></td>
                    <td><?= htmlspecialchars($p['email']); ?></td>
                    <td><?= htmlspecialchars($p['phone']); ?></td>
                    <td><?= htmlspecialchars($p['semester']); ?></td>
                    <td><?= htmlspecialchars($p['ipk']); ?></td>
                    <td><?= htmlspecialchars($p['beasiswa']); ?></td>
                    <td><?= htmlspecialchars($p['status']); ?></td>
                    <td><?= htmlspecialchars($p['berkas']); ?></td>
                    <td>
                    <form action="hapus.php?id=<?= $p['id']; ?>" method="POST" onsubmit="return confirm('Apakah anda yakin?')">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
