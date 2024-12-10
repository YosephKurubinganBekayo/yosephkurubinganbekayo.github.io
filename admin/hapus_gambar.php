<?php
// Cek apakah parameter 'src' ada
if (isset($_POST['src'])) {
    $src = $_POST['src'];

    // Mengonversi URL menjadi path file lokal
    $file_path = str_replace('http://' . $_SERVER['SERVER_NAME'], $_SERVER['DOCUMENT_ROOT'], $src);  // Gunakan $_SERVER['DOCUMENT_ROOT']

    // Debugging: Cek path yang dihasilkan
    echo "File Path: " . $file_path . "<br>";  // Tampilkan path file yang digunakan

    // Memastikan file ada dan menghapusnya
    if (file_exists($file_path)) {
        if (unlink($file_path)) {
            echo "Gambar berhasil dihapus: " . $file_path;
        } else {
            echo "Gagal menghapus gambar.";
        }
    } else {
        echo "File tidak ditemukan: " . $file_path;
    }
} else {
    echo "Tidak ada parameter src yang diterima.";
}
