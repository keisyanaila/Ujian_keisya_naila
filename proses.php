<?php
include 'config.php';
session_start();

// Proses DELETE
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['delete']);
    $query = "DELETE FROM siswa WHERE id='$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Data berhasil dihapus!";
    } else {
        $_SESSION['pesan'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: index.php");
    exit();
}

// Proses SAVE/UPDATE form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    
    if ($id != "") {
        // UPDATE
        $query = "UPDATE siswa SET 
                  nama_lengkap='$nama', 
                  nis='$nis', 
                  kelas='$kelas', 
                  jurusan='$jurusan' 
                  WHERE id='$id'";
        $pesan = "Data berhasil diupdate!";
    } else {
        // INSERT
        $query = "INSERT INTO siswa (nama_lengkap, nis, kelas, jurusan) 
                  VALUES ('$nama', '$nis', '$kelas', '$jurusan')";
        $pesan = "Data berhasil disimpan!";
    }
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = $pesan;
    } else {
        $_SESSION['pesan'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: index.php");
    exit();
}
?>