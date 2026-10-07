<?php
// ============================================
// Inisialisasi variabel & array error
// ============================================
$errors = [];
$nama = $nis = $email = $jurusan = $perusahaan = $alasan = "";
$tech_stack = [];

// ============================================
// Proses hanya jika tombol submit ditekan
// ============================================
if (isset($_POST['submit'])) {

    // --- Ambil data dari $_POST (dengan trim) ---
    $nama       = trim($_POST['nama'] ?? '');
    $nis        = trim($_POST['nis'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $jurusan    = $_POST['jurusan'] ?? '';
    $perusahaan = $_POST['perusahaan'] ?? '';
    $alasan     = trim($_POST['alasan'] ?? '');
    $tech_stack = $_POST['tech'] ?? []; // checkbox berupa array

    // --- Validasi field wajib (Nama & NIS) ---
    if (empty($nama)) {
        $errors[] = "Nama Lengkap wajib diisi!";
    }
    if (empty($nis)) {
        $errors[] = "NIS wajib diisi!";
    } elseif (!is_numeric($nis)) {
        $errors[] = "NIS harus berupa angka!";
    }

    // --- Validasi tambahan (opsional tapi bagus) ---
    if (empty($email)) {
        $errors[] = "Email wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid!";
    }
    if (empty($jurusan)) {
        $errors[] = "Kompetensi Keahlian wajib dipilih!";
    }
    if (empty($perusahaan)) {
        $errors[] = "Pilihan Perusahaan PKL wajib diisi!";
    }
    if (empty($alasan)) {
        $errors[] = "Alasan memilih perusahaan wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Peserta PKL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1, h2 { color: #2c3e50; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input[type=text], input[type=number], input[type=email],
        textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea { resize: vertical; min-height: 80px; }
        .radio-group, .check-group { margin-top: 6px; }
        .radio-group label, .check-group label {
            font-weight: normal;
            display: inline-block;
            margin-right: 15px;
        }
        button {
            margin-top: 20px;
            background: #3498db;
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }
        button:hover { background: #2980b9; }
        .error-box {
            background: #fdecea;
            border-left: 4px solid #e74c3c;
            color: #c0392b;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .success-box {
            background: #e8f8f5;
            border-left: 4px solid #1abc9c;
            padding: 15px 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .success-box h2 { margin-top: 0; color: #16a085; }
        .success-box table { border-collapse: collapse; width: 100%; }
        .success-box td { padding: 6px 8px; vertical-align: top; }
        .success-box td:first-child { font-weight: bold; width: 200px; }
    </style>
</head>
<body>
<div class="container">

    <h1>Form Pendaftaran Peserta PKL</h1>
    <p>Silakan lengkapi data berikut untuk mendaftar Praktik Kerja Lapangan.</p>

    <?php
    // Tampilkan pesan error jika ada
    if (!empty($errors)) {
        echo '<div class="error-box"><strong>Terjadi Kesalahan:</strong><ul>';
        foreach ($errors as $err) {
            echo "<li>" . htmlspecialchars($err) . "</li>";
        }
        echo '</ul></div>';
    }
    ?>

    <!-- ================= FORM ================= -->
    <form action="" method="post">
        <label for="nama">Nama Lengkap *</label>
        <input type="text" name="nama" id="nama"
               value="<?= htmlspecialchars($nama) ?>">

        <label for="nis">NIS *</label>
        <input type="number" name="nis" id="nis"
               value="<?= htmlspecialchars($nis) ?>">

        <label for="email">Email Siswa *</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($email) ?>">

        <label>Kompetensi Keahlian / Jurusan *</label>
        <div class="radio-group">
            <label><input type="radio" name="jurusan" value="SIJA"
                <?= ($jurusan === 'SIJA') ? 'checked' : '' ?>> SIJA</label>
            <label><input type="radio" name="jurusan" value="TJAT"
                <?= ($jurusan === 'TJAT') ? 'checked' : '' ?>> TJAT</label>
        </div>

        <label for="perusahaan">Pilihan Perusahaan PKL *</label>
        <select name="perusahaan" id="perusahaan">
            <option value="">-- Pilih Perusahaan --</option>
            <option value="PT Telkom Indonesia" <?= ($perusahaan === 'PT Telkom Indonesia') ? 'selected' : '' ?>>PT Telkom Indonesia</option>
            <option value="PT Astra International" <?= ($perusahaan === 'PT Freeport') ? 'selected' : '' ?>>PT Freeport</option>
            <option value="CV Kreatif Digital" <?= ($perusahaan === 'PT Pelindo') ? 'selected' : '' ?>>PT Pelindo</option>
            <option value="Startup Nusantara" <?= ($perusahaan === 'PT Pertamina') ? 'selected' : '' ?>>PT Pertamina</option>
        </select>

        <label>Kompetensi / Tech Stack yang Dikuasai</label>
        <div class="check-group">
            <?php
            $tech_options = ['HTML', 'CSS', 'JavaScript', 'PHP', 'MySQL', 'Python'];
            foreach ($tech_options as $t) {
                $checked = in_array($t, $tech_stack) ? 'checked' : '';
                echo "<label><input type='checkbox' name='tech[]' value='$t' $checked> $t</label>";
            }
            ?>
        </div>

        <label for="alasan">Alasan Memilih Perusahaan *</label>
        <textarea name="alasan" id="alasan"><?= htmlspecialchars($alasan) ?></textarea>

        <button type="submit" name="submit">Daftar Sekarang</button>
    </form>

    <?php
    // ============================================
    // Tampilkan data jika berhasil & tidak ada error
    // ============================================
    if (isset($_POST['submit']) && empty($errors)) {
        echo '<div class="success-box">';
        echo '<h2>✅ Pendaftaran Berhasil!</h2>';
        echo '<table>';
        echo '<tr><td>Nama Lengkap</td><td>: ' . htmlspecialchars($nama) . '</td></tr>';
        echo '<tr><td>NIS</td><td>: ' . htmlspecialchars($nis) . '</td></tr>';
        echo '<tr><td>Email</td><td>: ' . htmlspecialchars($email) . '</td></tr>';
        echo '<tr><td>Kompetensi Keahlian</td><td>: ' . htmlspecialchars($jurusan) . '</td></tr>';
        echo '<tr><td>Perusahaan PKL</td><td>: ' . htmlspecialchars($perusahaan) . '</td></tr>';
        $tech_str = !empty($tech_stack) ? implode(', ', $tech_stack) : '-';
        echo '<tr><td>Tech Stack</td><td>: ' . htmlspecialchars($tech_str) . '</td></tr>';
        echo '<tr><td>Alasan</td><td>: ' . nl2br(htmlspecialchars($alasan)) . '</td></tr>';
        echo '</table>';
        echo '</div>';
    }
    ?>

</div>
</body>
</html>