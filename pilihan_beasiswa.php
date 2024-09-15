
<?php
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
 
<div class="container mt-5">
    <h2 class="text-center">Pilih Jenis Beasiswa</h2>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Beasiswa Akademik</h5>
                    <p class="card-text">Beasiswa ini diberikan kepada mahasiswa dengan prestasi akademik terbaik.</p>
                    <a href="form_pendaftaran.php?jenis=akademik" class="btn btn-success">Beasiswa Akademik</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Beasiswa Non-Akademik</h5>
                    <p class="card-text">Beasiswa ini diberikan kepada mahasiswa dengan prestasi non-akademik, seperti olahraga atau seni.</p>
                    <a href="form_pendaftaran.php?jenis=non-akademik" class="btn btn-success">Beasiswa Non-Akademik</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>