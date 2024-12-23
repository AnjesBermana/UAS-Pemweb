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