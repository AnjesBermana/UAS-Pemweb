<?php
include 'koneksi/koneksi.php';
include 'session/session.php';

class Siswa {
    private $conn;

    // Constructor untuk menghubungkan dengan database
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Validasi di Sisi Server
    
    // Metode untuk validasi NISN s
    public function validasiNISN($nisn) {
        return preg_match('/^\d{10}$/', $nisn);
    }

    // Metode untuk validasi Tanggal Lahir 
    public function validasiTanggalLahir($tanggal_lahir) {
        $tanggal_parsed = DateTime::createFromFormat('Y-m-d', $tanggal_lahir);
        return $tanggal_parsed && $tanggal_parsed->format('Y-m-d') === $tanggal_lahir;
    }

    // Metode untuk menghitung usia
    public function hitungUsia($tanggal_lahir) {
        $tanggal_parsed = DateTime::createFromFormat('Y-m-d', $tanggal_lahir);
        $today = new DateTime();
        $age = $today->diff($tanggal_parsed)->y;
        return $age;
    }

    // Metode untuk validasi Nilai Ujian
    public function validasiNilaiUjian($nilai_ujian) {
        return is_numeric($nilai_ujian) && $nilai_ujian >= 0 && $nilai_ujian <= 100;
    }

    // Metode untuk validasi file foto
    public function validasiFoto($foto) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        return in_array($foto['type'], $allowed_types) && $foto['size'] <= 2 * 1024 * 1024;
    }

    // Metode untuk memindahkan file foto
    public function uploadFoto($foto) {
        $dir = "img/";
        $tmpfile = $foto['tmp_name'];
        $foto_name = $foto['name'];
        move_uploaded_file($tmpfile, $dir . $foto_name);
        return $foto_name;
    }

    // Metode untuk menambah data siswa
    public function tambahDataSiswa($nisn, $nama_siswa, $tanggal_lahir, $jenis_kelamin, $foto, $alamat, $nilai_ujian, $status_siswa) {
        $query = "INSERT INTO siswa (nisn, nama_siswa, tanggal_lahir, jenis_kelamin, foto_siswa, alamat, nilai_ujian, status_siswa) 
                  VALUES ('$nisn', '$nama_siswa', '$tanggal_lahir', '$jenis_kelamin', '$foto', '$alamat', '$nilai_ujian', '$status_siswa')";
        return mysqli_query($this->conn, $query);
    }

    // Metode untuk memperbarui data siswa
    public function updateDataSiswa($id_siswa, $nisn, $nama_siswa, $tanggal_lahir, $jenis_kelamin, $foto, $alamat, $nilai_ujian, $status_siswa) {
        $query = "UPDATE siswa 
                  SET nisn = '$nisn', nama_siswa = '$nama_siswa', tanggal_lahir = '$tanggal_lahir', 
                      jenis_kelamin = '$jenis_kelamin', foto_siswa = '$foto', alamat = '$alamat', 
                      nilai_ujian = '$nilai_ujian', status_siswa = '$status_siswa' 
                  WHERE id_siswa = '$id_siswa'";
        return mysqli_query($this->conn, $query);
    }

    // Metode untuk menghapus siswa
    public function hapusDataSiswa($id_siswa) {
        $queryShow = "SELECT * FROM siswa WHERE id_siswa = '$id_siswa';";
        $sqlShow = mysqli_query($this->conn, $queryShow);
        $result = mysqli_fetch_assoc($sqlShow);
        unlink("img/" . $result['foto_siswa']);

        $query = "DELETE FROM siswa WHERE id_siswa = '$id_siswa';";
        return mysqli_query($this->conn, $query);
    }
}

$siswaObj = new Siswa($conn);

if (isset($_POST['aksi'])) {
    // Ambil data dari form
    $nisn = $_POST['nisn'];
    $nama_siswa = $_POST['nama_siswa'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $nilai_ujian = $_POST['nilai_ujian'];
    $status_siswa = $_POST['status_siswa'];

    // Validasi NISN
    if (!$siswaObj->validasiNISN($nisn)) {
        echo "NISN harus terdiri dari 10 digit angka.";
        exit();
    }

    // Validasi Tanggal Lahir
    if (!$siswaObj->validasiTanggalLahir($tanggal_lahir)) {
        echo "Format tanggal lahir salah, harap gunakan format yang benar (YYYY-MM-DD).";
        exit();
    }

    // Validasi Usia
    if ($siswaObj->hitungUsia($tanggal_lahir) <= 15 || $siswaObj->hitungUsia($tanggal_lahir) >= 21) {
        echo "Usia harus antara 15 dan 21 tahun.";
        exit();
    }

    // Validasi Nilai Ujian
    if (!$siswaObj->validasiNilaiUjian($nilai_ujian)) {
        echo "Nilai ujian harus berupa angka antara 0 dan 100.";
        exit();
    }

    // Validasi Foto
    if (isset($_FILES['foto']) && !empty($_FILES['foto']['name']) && !$siswaObj->validasiFoto($_FILES['foto'])) {
        echo "File yang diunggah bukan gambar yang valid (hanya .jpg, .png, .gif yang diterima) atau ukuran file terlalu besar.";
        exit();
    }

    $foto = isset($_FILES['foto']) ? $siswaObj->uploadFoto($_FILES['foto']) : "";

    // Aksi tambah data
    if ($_POST['aksi'] == "add") {
        if ($siswaObj->tambahDataSiswa($nisn, $nama_siswa, $tanggal_lahir, $jenis_kelamin, $foto, $alamat, $nilai_ujian, $status_siswa)) {
            header("location: edit.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } 
    // Aksi edit data
    else if ($_POST['aksi'] == "edit") {
        $id_siswa = $_POST['id_siswa'];
    
        if (!empty($_FILES['foto']['name'])) {
            $foto = $siswaObj->uploadFoto($_FILES['foto']);
        } else {
            $foto = $_POST['foto_lama'];
        }
    
        if ($siswaObj->updateDataSiswa($id_siswa, $nisn, $nama_siswa, $tanggal_lahir, $jenis_kelamin, $foto, $alamat, $nilai_ujian, $status_siswa)) {
            header("location: edit.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

if (isset($_GET['hapus'])) {
    $id_siswa = $_GET['hapus'];
    if ($siswaObj->hapusDataSiswa($id_siswa)) {
        header("location: edit.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>