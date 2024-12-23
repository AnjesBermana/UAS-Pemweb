# UAS Pemrograman Web
# WEB PENDAFTARAN SISWA SMA

Proyek ini merupakan implementasi tugas akhir untuk UAS Pemrograman Web 2024/2025

## Daftar Isi
- [Bagian 1: Client-side Programming](#bagian-1-client-side-programming)
- [Bagian 2: Server-side Programming](#bagian-2-server-side-programming)
- [Bagian 3: Database Management](#bagian-3-database-management)
- [Bagian 4: State Management](#bagian-4-state-management)
- [Bagian Bonus: Hosting Aplikasi Web](#bagian-bonus-hosting-aplikasi-web)
- [Petunjuk Penggunaan](#petunjuk-penggunaan)

---

## Bagian 1: Client-side Programming

### 1.1 Manipulasi DOM dengan JavaScript
- Membuat form dengan minimal 4 elemen input (contoh: teks, checkbox, radio).
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

- Menampilkan data dari server dalam tabel HTML.
<div class="table-responsive">
            <table class="table align-middle table-bordered table-hover">
                <thead style="text-align:center">
                    <tr>
                        <th><center>No.</center></th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat Lengkap</th>
                        <th>Nilai Ujian</th>
                        <th>Status Siswa</th>
                        <th>Foto Siswa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($result = mysqli_fetch_assoc($sql)) {
                    ?>
                    <tr style="text-align:center">
                        <td><center><?php echo $no++; ?></center></td>
                        <td><?php echo $result['nisn']; ?></td>
                        <td><?php echo $result['nama_siswa']; ?></td>
                        <td><?php echo $result['tanggal_lahir']; ?></td>
                        <td><?php echo $result['jenis_kelamin']; ?></td>
                        <td><?php echo $result['alamat']; ?></td>
                        <td><?php echo $result['nilai_ujian']; ?></td>
                        <td><?php echo $result['status_siswa']; ?></td>
                        <td><img src="img/<?php echo $result['foto_siswa']; ?>" style="width:90px; height:135px"></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>



### 1.2 Event Handling
- Tambahkan minimal 3 event yang berbeda untuk meng-handle form pada 1.1. serta menambahkan validasi input menggunakan JavaScript sebelum diproses oleh server.
function validateForm(event) {
    const form = event.target;
    const nisn = form.nisn.value;
    const namaSiswa = form.nama_siswa.value;
    const tanggalLahir = form.tanggal_lahir.value;
    const jenisKelamin = form.jenis_kelamin.value;
    const alamat = form.alamat.value;
    const statusSiswa = form.status_siswa.value;
    const foto = form.foto.files[0];
    const nilaiUjian = form.nilai_ujian.value;
    const aksi = form.aksi.value;

    // Validate NISN
    if (nisn.length !== 10) {
        alert("NISN harus terdiri dari 10 digit!");
        event.preventDefault();
        return false;
    }

    // Validate Nama Siswa
    if (!/^[A-Za-z\s]+$/.test(namaSiswa)) {
        alert("Nama Siswa hanya boleh mengandung huruf dan spasi!");
        event.preventDefault();
        return false;
    }

    // Validate Tanggal Lahir (Usia Siswa Antara 15 dan 21 Tahun)
    const today = new Date();
    const birthDate = new Date(tanggalLahir);
    let age = today.getFullYear() - birthDate.getFullYear();
    const m = today.getMonth() - birthDate.getMonth();

    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age <= 15 || age >= 21 ) {
        alert("Tanggal Lahir harus membuat usia siswa antara 15 dan 21 tahun!");
        event.preventDefault();
        return false;
    }

    // Validate Jenis Kelamin
    if (jenisKelamin === "") {
        alert("Jenis Kelamin harus dipilih!");
        event.preventDefault();
        return false;
    }

    // Validate Alamat Lengkap
    if (alamat === "") {
        alert("Alamat Lengkap harus diisi!");
        event.preventDefault();
        return false;
    }

    // Foto Siswa hanya wajib jika aksi adalah add (menambah data baru)
    if (aksi === "add" && !foto) {
        alert("Foto Siswa harus diunggah!");
        event.preventDefault();
        return false;
    } else if (foto) {
        // Jika foto diupload, validasi tipe dan ukuran file
        const fileType = foto.type;
        if (fileType !== 'image/jpeg' && fileType !== 'image/png') {
            alert("Hanya file JPG atau PNG yang diperbolehkan!");
            event.preventDefault();
            return false;
        }

        const fileSize = foto.size;
        if (fileSize > 2 * 1024 * 1024) { // 2MB
            alert("Ukuran file harus kurang dari 2MB!");
            event.preventDefault();
            return false;
        }
    }

    // Validate Status Siswa
    if (statusSiswa === "") {
        alert("Status Siswa harus dipilih!");
        event.preventDefault();
        return false;
    }

    // Validate Nilai Ujian
    if (nilaiUjian === "" || isNaN(nilaiUjian) || nilaiUjian < 0 || nilaiUjian > 100) {
        alert("Nilai Ujian harus diisi dengan angka antara 0 dan 100!");
        event.preventDefault();
        return false;
    }

    return true;
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('form').addEventListener('submit', validateForm);
});

---

## Bagian 2: Server-side Programming

### 2.1 Pengelolaan Data dengan PHP
- Menggunakan metode POST atau GET untuk menerima data form.

if (isset($_POST['aksi'])) {
    // Ambil data dari form
    $nisn = $_POST['nisn'];
    $nama_siswa = $_POST['nama_siswa'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $nilai_ujian = $_POST['nilai_ujian'];
    $status_siswa = $_POST['status_siswa'];
    
- Melakukan validasi server-side
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

- Menyimpan data ke basis data, termasuk data jenis browser dan alamat IP pengguna.

if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        if ($password == $data['password']) {
            // Deteksi IP dan Browser
            $ip_address = getUserIp();
            $browser_info = getBrowser($_SERVER['HTTP_USER_AGENT']);

            // Simpan IP dan browser ke database
            $update_sql = "UPDATE users SET ip_address='$ip_address', browser_info='$browser_info' WHERE username='$username'";
            mysqli_query($conn, $update_sql);

- Tampilkan IP dan Jenis Browser
function toggleIPBrowserInfo() {
        var infoDiv = document.getElementById("ipBrowserInfo");
        // Cek apakah elemen sedang ditampilkan
        if (infoDiv.style.display === "none" || infoDiv.style.display === "") {
            infoDiv.style.display = "block";
        } else {
            infoDiv.style.display = "none";
        }
    }

### 2.2 Objek PHP Berbasis OOP
- Membuat objek PHP dengan minimal dua metode dan menggunakannya dalam skenario tertentu.
   // Memnambah data
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
    // Hapus Data
    public function hapusDataSiswa($id_siswa) {
        $queryShow = "SELECT * FROM siswa WHERE id_siswa = '$id_siswa';";
        $sqlShow = mysqli_query($this->conn, $queryShow);
        $result = mysqli_fetch_assoc($sqlShow);
        unlink("img/" . $result['foto_siswa']);

        $query = "DELETE FROM siswa WHERE id_siswa = '$id_siswa';";
        return mysqli_query($this->conn, $query);
    }
    // Update Data
    public function updateDataSiswa($id_siswa, $nisn, $nama_siswa, $tanggal_lahir, $jenis_kelamin, $foto, $alamat, $nilai_ujian, $status_siswa) {
        $query = "UPDATE siswa 
                  SET nisn = '$nisn', nama_siswa = '$nama_siswa', tanggal_lahir = '$tanggal_lahir', 
                      jenis_kelamin = '$jenis_kelamin', foto_siswa = '$foto', alamat = '$alamat', 
                      nilai_ujian = '$nilai_ujian', status_siswa = '$status_siswa' 
                  WHERE id_siswa = '$id_siswa'";
        return mysqli_query($this->conn, $query);
    }

---

## Bagian 3: Database Management

### 3.1 Pembuatan Tabel Database
- Membuat tabel sesuai kebutuhan website aplikasi .

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nama_siswa` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `foto_siswa` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nilai_ujian` int(11) DEFAULT NULL,
  `status_siswa` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) NOT NULL,
  `browser_info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


### 3.2 Konfigurasi Koneksi Database
- Menyiapkan file konfigurasi untuk menghubungkan aplikasi dengan basis data.
<?php
    class Koneksi {
        private $host;
        private $user;
        private $pass;
        private $db;
        private $conn;

        public function __construct($host, $user, $pass, $db) {
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->db = $db;
            $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
            if (!$this->conn) {
                die("Koneksi gagal: " . mysqli_connect_error());
            }
        }

        public function getConn() {
            return $this->conn;
        }
    }

    $koneksi = new Koneksi('localhost', 'root', '', 'db_sekolah');
    $conn = $koneksi->getConn();
?>

### 3.3 Manipulasi Data pada Database
- Menambahkan, memperbarui, menghapus, dan membaca data dari tabel.
Fungsi telah ada pada 2.2 dan tinggal dipanggil

if (isset($_POST['aksi'])) {
    // Ambil data dari form
    $nisn = $_POST['nisn'];
    $nama_siswa = $_POST['nama_siswa'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $nilai_ujian = $_POST['nilai_ujian'];
    $status_siswa = $_POST['status_siswa'];

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

//

if (isset($_GET['hapus'])) {
    $id_siswa = $_GET['hapus'];
    if ($siswaObj->hapusDataSiswa($id_siswa)) {
        header("location: edit.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
---

## Bagian 4: State Management

### 4.1 State Management dengan Session
- Menggunakan `session_start()` untuk memulai session dan menyimpan informasi pengguna.
<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

- include session start ditaruh pada login, logout, edit, tampil, kelola

### 4.2 Pengelolaan State dengan Cookie dan Browser Storage
- Membuat fungsi untuk menetapkan, mendapatkan, dan menghapus cookie.
- Cookie disini digunakan untuk meniyimpan tema yang digunakan pada tampilan.php sehingga ketika user logout atau refresh tema masih ada sesuai dengan tema yang dipakai sebelumnya

// Fungsi untuk menetapkan cookie
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const date = new Date();
            // Mengatur masa berlaku cookie
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Fungsi untuk mendapatkan cookie
    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Fungsi cookie untuk mengubah tema
    function toggleTheme() {
    const body = document.body;
    const isDark = body.getAttribute('data-theme') === 'dark';
    body.setAttribute('data-theme', isDark ? 'light' : 'dark');
    setCookie("theme", isDark ? 'light' : 'dark', 30);
    }

    window.onload = function() {
        const theme = getCookie("theme") || 'light';
        document.body.setAttribute('data-theme', theme);
    }
- Menggunakan browser storage (localStorage atau sessionStorage) untuk menyimpan data secara lokal.
- LocalStorage digunakan disaat user ingin menambahkan data dan jika user keluar ataupun ingin menambah data kembali maka data yang sebelumnya belum diinputkan tersimpan dan diterapkan kembali di form, penghapusan terjadi ketika user telah melakukan submit

function saveToLocalStorage() {
    // Cek apakah form dalam mode tambah data
    const action = document.querySelector('input[name="aksi"]').value;
    if (action === 'add') {
        const nisn = document.getElementById('nisn').value;
        const nama = document.getElementById('nama').value;
        const tanggalLahir = document.getElementById('tanggal_lahir').value;
        const jenisKelamin = document.getElementById('jkel').value;
        const alamat = document.getElementById('alamat').value;
        const nilaiUjian = document.getElementById('nilai_ujian').value;
        const statusSiswa = document.getElementById('status_siswa').value;

        const formData = {
            nisn: nisn,
            nama_siswa: nama,
            tanggal_lahir: tanggalLahir,
            jenis_kelamin: jenisKelamin,
            alamat: alamat,
            nilai_ujian: nilaiUjian,
            status_siswa: statusSiswa
        };

        // Simpan ke localStorage
        localStorage.setItem('formData', JSON.stringify(formData));
    }
}

// Fungsi untuk mengisi form dari localStorage
function populateFormFromLocalStorage() {
    // Cek apakah form dalam mode tambah data
    const action = document.querySelector('input[name="aksi"]').value;
    if (action === 'add') {
        const storedData = localStorage.getItem('formData');
        if (storedData) {
            const formData = JSON.parse(storedData);
            document.getElementById('nisn').value = formData.nisn;
            document.getElementById('nama').value = formData.nama_siswa;
            document.getElementById('tanggal_lahir').value = formData.tanggal_lahir;
            document.getElementById('jkel').value = formData.jenis_kelamin;
            document.getElementById('alamat').value = formData.alamat;
            document.getElementById('nilai_ujian').value = formData.nilai_ujian;
            document.getElementById('status_siswa').value = formData.status_siswa;
        }
    }
}

// Fungsi untuk menghapus data dari localStorage setelah form disubmit
function clearLocalStorage() {
    const action = document.querySelector('input[name="aksi"]').value;
    if (action === 'add') {
        localStorage.removeItem('formData');
    }
}

// Pastikan data ditampilkan saat halaman dimuat
window.onload = function() {
    populateFormFromLocalStorage();
}

const form = document.querySelector('form');
form.addEventListener('input', saveToLocalStorage);

// Hapus localStorage setelah submit
form.addEventListener('submit', clearLocalStorage);

---

## Bagian Bonus: Hosting Aplikasi Web

# Panduan Hosting Aplikasi Web di InfinityFree

## 1. Langkah-Langkah Meng-Host Aplikasi Web

### Registrasi Akun
1. Daftar akun di platform hosting gratis [InfinityFree](https://infinityfree.com).  
2. Verifikasi akun melalui email yang telah didaftarkan.  
3. Pilih paket hosting gratis yang tersedia untuk memulai.  

### Persiapan File
- Pastikan semua file aplikasi web telah dipersiapkan dan tidak mengandung error.  
- Periksa kembali struktur folder agar sesuai standar hosting, dengan file utama ditempatkan di dalam folder `htdocs`.  

### Upload dan Konfigurasi
1. Login ke **control panel** InfinityFree menggunakan akun tadi.  
2. Upload file dan folder aplikasi ke direktori `htdocs`.  
3. Jika aplikasi menggunakan basis data:
   - Buat database MySQL melalui menu **Admin MySQL** di control panel.  
   - Import struktur tabel ke dalam database.  

---

## 2. Pemilihan Penyedia Hosting
### Mengapa Memilih InfinityFree?
- **Gratis:** Tidak memerlukan biaya langganan, dengan bandwidth tanpa batas.  
- **Dukungan Teknologi:** Mendukung PHP dan MySQL, sesuai dengan kebutuhan aplikasi web.  
- **Antarmuka Sederhana:** Mudah digunakan, bahkan oleh pemula.  

---

## 3. Keamanan Aplikasi Web
Langkah-langkah berikut diterapkan untuk memastikan keamanan aplikasi web:
- **HTTPS:** Selalu menggunakan protokol HTTPS untuk mengamankan transfer data.  
- **Validasi Input:** Menerapkan validasi pada semua data input pengguna dari front end hingga back end.  
- **Prepared Statements:** Menggunakan prepared statements pada semua query SQL untuk melindungi database.    
- **Backup Rutin:** Melakukan backup database secara berkala untuk mencegah kehilangan data.  

---

## 4. Konfigurasi Server
### Kredensial Database
File `database.php` dikonfigurasi dengan kredensial yang diberikan oleh InfinityFree:  
```php
$servername = "sql305.infinityfree.com";
$username = [Username ditetapkan dari websitenya]
$password = [Password ditetapkan dari websitenya]
$database = if0_37973435_db_sekolah
