<?php
include 'config.php';
session_start();

// Variabel default untuk form
$id = "";
$nama = "";
$nis = "";
$kelas = "";
$jurusan = "";
$mode = "tambah";

// ini untuk edit, kalo ada edit,  ambil data dari database
if (isset($_GET['edit'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $query = "SELECT * FROM siswa WHERE id='$id'";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $nama = $row['nama_lengkap'];
        $nis = $row['nis'];
        $kelas = $row['kelas'];
        $jurusan = $row['jurusan'];
        $mode = "edit";
    }
}

// Ambil semua data untuk tabel
$query_siswa = "SELECT * FROM siswa ORDER BY id DESC";
$result_siswa = mysqli_query($koneksi, $query_siswa);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Manajemen Data Siswa</h1>
    
    <!-- Tampilkan pesan -->
    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="notif success">
            <?php 
            echo $_SESSION['pesan']; 
            unset($_SESSION['pesan']);
            ?>
        </div>
    <?php endif; ?>
    
    <!-- FORM INPUT -->
    <div class="form-input">
        <h2><?php echo ($mode == "tambah") ? "Tambah Data" : "Edit Data"; ?></h2>
        
        <form method="POST" action="proses.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <div>
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" 
                       value="<?php echo htmlspecialchars($nama); ?>" required>
            </div>
            
            <div>
                <input type="text" name="nis" placeholder="NIS" 
                       value="<?php echo htmlspecialchars($nis); ?>" required>
            </div>
            
            <div>
                <select name="kelas" required>
                    <option value="">Pilih Kelas</option>
                    <option value="10" <?php if($kelas=='10') echo 'selected'; ?>>10</option>
                    <option value="11" <?php if($kelas=='11') echo 'selected'; ?>>11</option>
                    <option value="12" <?php if($kelas=='12') echo 'selected'; ?>>12</option>
                </select>
            </div>
            
            <div>
                <select name="jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="pengembangan perangkat lunak dan gim" 
                        <?php if($jurusan=='pengembangan perangkat lunak dan gim') echo 'selected'; ?>>
                        PPLG
                    </option>
                    <option value="Desain Komunikasi Visual" 
                        <?php if($jurusan=='Desain Komunikasi Visual') echo 'selected'; ?>>
                        DKV
                    </option>
                    <option value="Teknik Jaringan Komputer dan Telekomunikasi" 
                        <?php if($jurusan=='Teknik Jaringan Komputer dan Telekomunikasi') echo 'selected'; ?>>
                        TJKT
                    </option>
                    <option value="Pemasaran" 
                        <?php if($jurusan=='Pemasaran') echo 'selected'; ?>>
                        Pemasaran
                    </option>
                    <option value="perhotelan" 
                        <?php if($jurusan=='perhotelan') echo 'selected'; ?>>
                        Perhotelan
                    </option>
                </select>
            </div>
            
            <div>
                <button type="submit">Simpan</button>
                <?php if ($mode == "edit"): ?>
                    <a href="index.php">
                        <button type="button" class="cancel">Batal</button>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <!-- TABEL DATA -->
    <h2>Data Siswa</h2>
    
    <?php if (mysqli_num_rows($result_siswa) > 0): ?>
        <table border="1">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
            
            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($result_siswa)): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($row['nis']); ?></td>
                    <td><?php echo htmlspecialchars($row['kelas']); ?></td>
                    <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn edit">
                           <button> Edit </button>
                        </a>
                        <a href="proses.php?delete=<?php echo $row['id']; ?>" 
                           class="btn delete"
                           onclick="return confirm('Yakin hapus data ini?')">
                            <button> hapus </button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Tidak ada data siswa.</p>
    <?php endif; ?>

<?php mysqli_close($koneksi); ?>
</body>
</html>