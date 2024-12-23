<?php
include 'koneksi/koneksi.php';
include 'session/session.php';

$id_siswa = '';
$nisn = '';
$nama_siswa = '';
$jenis_kelamin = '';
$alamat = '';
$tanggal_lahir = '';
$nilai_ujian = '';
$status_siswa = '';

if (isset($_GET['ubah'])) {
    $id_siswa = $_GET['ubah'];

    $query = "SELECT * FROM siswa WHERE id_siswa = '$id_siswa'";
    $sql = mysqli_query($conn, $query);

    $result = mysqli_fetch_assoc($sql);

    $nisn = $result['nisn'];
    $nama_siswa = $result['nama_siswa'];
    $jenis_kelamin = $result['jenis_kelamin'];
    $alamat = $result['alamat'];
    $tanggal_lahir = $result['tanggal_lahir'];
    $nilai_ujian = $result['nilai_ujian'];
    $status_siswa = $result['status_siswa'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="font_awesome/css/font-awesome.min.css">
        <title>UAS - Anjes Bermana</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style/style_edit_kelola.css">
    </head>

    <body>
        <div class="stars"></div>
        <nav class="navbar bg-body-tertiary bg-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Tambah dan Edit Data</a>
            </div>
        </nav>
        <div class="container">
            <form method="POST" action="proses.php" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo $id_siswa; ?>" name="id_siswa">
                <input type="hidden" name="aksi" value="<?php echo isset($_GET['ubah']) ? 'edit' : 'add'; ?>">

                <div class="mb-3 row">
                    <label for="nisn" class="col-sm-2 col-form-label">NISN</label>
                    <div class="col-sm-10">
                        <input required type="text" name="nisn" class="form-control" id="nisn" placeholder="Ex : 123456" value="<?php echo $nisn; ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Siswa</label>
                    <div class="col-sm-10">
                        <input required type="text" name="nama_siswa" class="form-control" id="nama" placeholder="Ex : Andri" value="<?php echo $nama_siswa; ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input required type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" value="<?php echo $tanggal_lahir; ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <select required id="jkel" name="jenis_kelamin" class="form-select">
                            <option value="" disabled <?php if (empty($jenis_kelamin)) { echo "selected"; } ?>>Pilih Jenis Kelamin</option>
                            <option <?php if ($jenis_kelamin == 'Laki-laki') { echo "selected"; } ?> value="Laki-laki">Laki-laki</option>
                            <option <?php if ($jenis_kelamin == 'Perempuan') { echo "selected"; } ?> value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                    <div class="col-sm-10">
                        <textarea required class="form-control" id="alamat" name="alamat" placeholder="Ex : Jl. Raya 123" rows="3"><?php echo $alamat; ?></textarea>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="nilai_ujian" class="col-sm-2 col-form-label">Nilai Ujian</label>
                    <div class="col-sm-10">
                        <input required type="number" name="nilai_ujian" class="form-control" id="nilai_ujian" placeholder="Ex : 90" value="<?php echo $nilai_ujian; ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="status_siswa" class="col-sm-2 col-form-label">Status Siswa</label>
                    <div class="col-sm-10">
                        <select id="status_siswa" name="status_siswa" class="form-select" required>
                            <option value="" disabled <?php echo empty($status_siswa) ? "selected" : ""; ?>>Pilih Status Siswa</option>
                            <option value="Aktif" <?php echo ($status_siswa === 'Aktif') ? "selected" : ""; ?>>Aktif</option>
                            <option value="Non-aktif" <?php echo ($status_siswa === 'Non-aktif') ? "selected" : ""; ?>>Non-aktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="foto" class="col-sm-2">Foto Siswa <br> (Max 2MB)</label>
                    <div class="col-sm-10">
                        <input type="file" name="foto" id="foto" class="form-control" <?php echo !isset($_GET['ubah']) ? 'required' : ''; ?>>
                    </div>
                </div>

                <?php if (!empty($result['foto_siswa'])): ?>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Foto Saat Ini</label>
                        <div class="col-sm-10">
                            <img src="img/<?php echo $result['foto_siswa']; ?>" alt="Foto Siswa" width="150" class="img-thumbnail">
                            <input type="hidden" name="foto_lama" value="<?php echo $result['foto_siswa']; ?>">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mb-3 row mt-4">
                    <div class="col">
                        <?php
                        if (isset($_GET['ubah'])) {
                            ?>
                            <button type="submit" name="aksi" value="edit" class="btn btn-primary">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                Simpan Perubahan
                            </button>
                            <?php
                        } else {
                            ?>
                            <button type="submit" name="aksi" value="add" class="btn btn-primary"
                                onClick="return confirm('Are u sure about this ?')">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                Tambahkan
                            </button>
                            <?php
                        }
                        ?>
                        <a href="edit.php" type="button" class="btn btn-danger">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <script src="js/validateForm.js"></script>
        <script src="js/localStorage.js"></script>
    </body>
</html>
