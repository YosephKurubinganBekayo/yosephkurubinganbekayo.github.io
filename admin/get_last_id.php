
<?php
// Include koneksi database

header('Content-Type: application/json'); // Pastikan ini mengembalikan JSON
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    
    // Koneksi ke database
    include 'inc/koneksi.php';

    // Query untuk mencari nomor induk terakhir berdasarkan tahun
    $query_tahun = "SELECT no_induk FROM buku WHERE no_induk LIKE '%/Dinarpusta/$tahun' ORDER BY id_buku DESC LIMIT 1";
    $result_tahun = mysqli_query($koneksi, $query_tahun);
    
    if (!$result_tahun) {
        echo json_encode(['error' => 'Query failed: ' . mysqli_error($koneksi)]);
        exit;
    }

    $data_tahun = mysqli_fetch_array($result_tahun);

    if ($data_tahun) {
        // Jika sudah ada data di tahun tersebut, ambil nomor urut terakhir dan tambahkan 1
        $no_urut_terakhir = (int)substr($data_tahun['no_induk'], 0, 3); // Ambil 3 digit pertama
        $no_urut_baru = $no_urut_terakhir + 1;
    } else {
        // Jika belum ada data untuk tahun tersebut, mulai dari 1
        $no_urut_baru = 1;
    }

    // Format nomor urut menjadi 3 digit
    $no_urut_format = str_pad($no_urut_baru, 3, '0', STR_PAD_LEFT);
    $no_induk_baru = "$no_urut_format/Dinarpusta/$tahun";
    $id_buku_baru = $no_urut_format . $tahun;

    // Mengembalikan data dalam format JSON
    echo json_encode([
        'id_buku_baru' => $id_buku_baru,
        'no_induk_baru' => $no_induk_baru
    ]);
} else {
    echo json_encode(['error' => 'Tahun tidak ditemukan']);
}
?>

