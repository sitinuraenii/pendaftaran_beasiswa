<?php
require 'function.php';
require 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai IPK dari form
    $ipk = floatval($_POST['ipk']); // Konversi ke float

    if ($ipk < 3) {
        echo "IPK Anda kurang dari 3. Anda tidak memenuhi syarat untuk mendaftar beasiswa.";
    } else {
        // Validasi email
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            echo "Format email tidak valid.";
        } else {
            // Direktori tujuan untuk menyimpan file yang diunggah
            $target_dir = "uploads/";

            // Ambil informasi file yang diunggah
            $berkas = $_FILES['berkas']['name'];

            // Pastikan file telah dipilih
            if ($berkas) {
                $target_file = $target_dir . basename($berkas); // Gabungkan nama file dengan direktori tujuan

                // Ekstensi yang diizinkan
                $allowed_extensions = array('pdf', 'jpg', 'zip');
                $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);

                // Cek apakah file memiliki ekstensi yang diizinkan
                if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                    echo "Format file tidak diizinkan. Hanya file .pdf, .jpg, atau .zip yang diizinkan.";
                } else {
                    // Cek apakah folder tujuan ada dan bisa diakses
                    if (is_dir($target_dir) && is_writable($target_dir)) {
                        // Pindahkan file yang diunggah ke direktori tujuan
                        if (move_uploaded_file($_FILES['berkas']['tmp_name'], $target_file)) {
                            echo "Berkas berhasil diunggah.";
                            
                            $data = [
                                'nama' => $_POST['nama'],
                                'email' => $email,
                                'phone' => $_POST['phone'],
                                'semester' => $_POST['semester'],
                                'ipk' => $ipk,
                                'beasiswa' => $_POST['beasiswa'],
                                'status' => 'Belum diverifikasi',
                                'berkas' => $target_file  // Simpan path file di database
                            ];

                            // Simpan data ke database
                            if (tambah($data) > 0) {
                                header("Location: hasil.php");
                                exit();
                            } else {
                                echo "Gagal menyimpan data.";
                            }
                        } else {
                            echo "Maaf, terjadi kesalahan saat mengunggah file.";
                        }
                    } else {
                        echo "Direktori tujuan tidak ada atau tidak bisa ditulisi.";
                    }
                }
            } else {
                echo "Silakan pilih file untuk diunggah.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css" />
    <script>
       function checkIPK() {
            const ipk = parseFloat(document.getElementById('ipk').value);
            const beasiswa = document.getElementById('beasiswa');
            const berkas = document.getElementById('berkas');
            const simpan = document.getElementById('simpan');//mendapatkan elemnt html dengan id

            if (ipk < 3) {
                beasiswa.disabled = true;
                berkas.disabled = true;
                simpan.disabled = true;
            } else {
                beasiswa.disabled = false;
                berkas.disabled = false;
                simpan.disabled = false;
                beasiswa.focus();
            }
        }

        // Fungsi untuk memvalidasi email
        function validateEmail() {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('email-error');
            const email = emailInput.value;

            if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                emailError.textContent = "Format email tidak valid.";
                emailInput.classList.add('is-invalid');
            } else {
                emailError.textContent = "";
                emailInput.classList.remove('is-invalid');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const emailInput = document.getElementById('email');
            emailInput.addEventListener('blur', () => {
                validateEmail();
            });
        });
   
    </script>
</head>
<body onload="checkIPK()">

<h1 class="mb-4 pt-4 mt-5 text-center">Daftar Beasiswa</h1>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                Registrasi Beasiswa
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                   
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-4 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required />
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required oninput="validateEmail()" />
                            <div id="email-error" class="text-danger"></div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-4 col-form-label">Nomor HP</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor HP" required />
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="semester" class="col-sm-4 col-form-label">Semester</label>
                        <div class="col-sm-8">
                        <select class="form-select" id="semester" name="semester" required>
                            <option value="" disabled selected>Pilih Semester</option>
                            <?php for($i = 1; $i <= 8; $i++): ?>
                                <option value="<?php echo $i; ?>">Semester <?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="ipk" class="col-sm-4 col-form-label">IPK Terakhir</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.01" class="form-control" id="ipk" name="ipk" placeholder="Masukkan IPK" required onchange="checkIPK()">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="beasiswa" class="col-sm-4 col-form-label">Beasiswa</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="beasiswa" name="beasiswa" required>
                                <option value="" disabled selected>Pilih Beasiswa</option>
                                <option value="akademik" <?= isset($_POST['beasiswa']) && $_POST['beasiswa'] == 'akademik' ? 'selected' : '' ?>>Beasiswa Akademik</option>
                                <option value="non-akademik" <?= isset($_POST['beasiswa']) && $_POST['beasiswa'] == 'non-akademik' ? 'selected' : '' ?>>Beasiswa Non-Akademik</option>
                            </select>
                       </div>
                    </div>

                    <div class="mb-3 row pt-3">
                        <label for="berkas" class="col-sm-4 col-form-label">Upload Berkas Persyaratan</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="berkas" name="berkas" accept=".pdf,.jpg,.zip" />
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-sm-8 offset-sm-4">
                            <button type="submit" class="btn btn-primary" id="simpan">Daftar</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='pilihan_beasiswa.php'">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>
