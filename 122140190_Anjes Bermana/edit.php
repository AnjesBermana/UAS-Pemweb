<?php
    include '../koneksi/koneksi.php';
    include '../session/session.php';

    $query = "SELECT * FROM siswa;";
    $sql = mysqli_query($conn, $query);
    $no = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="font_awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style_edit_kelola.css">
    <title>UAS</title>
</head>
<body>
    <div class="stars"></div>
    <nav class="navbar bg-body-tertiary bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Edit Data</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-4">Data Siswa SMAN 54 New York</h1>
        <figure>
            <blockquote class="blockquote">
                <p>Harap perhatikan setiap bidang yang diisi.</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                CRUD <cite title="Source Title">Create Read Update Delete</cite>
            </figcaption>
        </figure>

        <a href="tampilan.php" class="btn btn-warning mb-3 me-1">
            <i class="fa fa-eye"></i> Lihat Data
        </a>
        <a href="kelola.php" class="btn btn-success mb-3">
            <i class="fa fa-plus"></i> Tambah Data
        </a>
        <a href="logout.php" class="btn btn-danger mb-3">
            <i class="fa fa-sign-out"></i> Logout
        </a>

        <div class="table-responsive">
            <table class="table align-middle table-bordered table-hover">
                <thead style="text-align:center">
                    <tr>
                        <th>No.</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat Lengkap</th>
                        <th>Nilai Ujian</th>
                        <th>Status Siswa</th>
                        <th>Foto Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody style="text-align:center">
                    <?php while ($result = mysqli_fetch_assoc($sql)): ?>
                        <tr>
                            <td><?php echo ++$no; ?></td>
                            <td><?php echo $result['nisn']; ?></td>
                            <td><?php echo $result['nama_siswa']; ?></td>
                            <td><?php echo $result['tanggal_lahir']; ?></td>
                            <td><?php echo $result['jenis_kelamin']; ?></td>
                            <td><?php echo $result['alamat']; ?></td>
                            <td><?php echo $result['nilai_ujian']; ?></td>
                            <td><?php echo $result['status_siswa']; ?></td>
                            <td><img src="<?php echo 'img/' . $result['foto_siswa']; ?>" style="width:90px; height:135px"></td>
                            <td>
                                <a href="kelola.php?ubah=<?php echo $result['id_siswa']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="proses.php?hapus=<?php echo $result['id_siswa']; ?>" class="btn btn-danger btn-sm" 
                                   onClick="return confirm('Are you sure about this?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>        
        </div>
    </div>
</body>
</html>