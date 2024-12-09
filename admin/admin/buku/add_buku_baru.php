

<?php
// Mengambil koneksi ke database

// Cek apakah form disubmit
if (isset($_POST['Simpan'])) {
  // Ambil data dari form
  $tanggal_terima = $_POST['tanggal_terima'];
  $tahun = substr($tanggal_terima, 2, 2); // Ambil dua digit terakhir tahun

  // Query untuk mencari nomor induk terakhir berdasarkan tahun
  $query_tahun = "SELECT id_buku, no_induk FROM buku WHERE no_induk LIKE '%/Dinarpusta/$tahun' ORDER BY CAST(id_buku AS UNSIGNED) DESC LIMIT 1";
  $result_tahun = mysqli_query($koneksi, $query_tahun);
  $data_tahun = mysqli_fetch_array($result_tahun);

  if ($data_tahun) {
    // Jika sudah ada data di tahun tersebut, ambil ID terakhir dan tambahkan 1
    $id_buku_terakhir = (int)$data_tahun['id_buku'];
    $id_buku_baru = $id_buku_terakhir + 1;

    // Ambil nomor urut dari no_induk terakhir
    $no_urut_terakhir = (int)substr($data_tahun['no_induk'], 0, 3); // Ambil 3 digit pertama
    $no_urut_baru = $no_urut_terakhir + 1;
  } else {
    // Jika belum ada data untuk tahun tersebut, mulai dari 1
    $id_buku_baru = 1;
    $no_urut_baru = 1;
  }

  // Format ID dan nomor urut
  $id_buku_format = str_pad($id_buku_baru, 3, '0', STR_PAD_LEFT);
  $no_urut_format = str_pad($no_urut_baru, 3, '0', STR_PAD_LEFT);
  $no_induk_baru = "$no_urut_format/Dinarpusta/$tahun";

  // Query untuk menyimpan data ke database
  $sql_simpan = "INSERT INTO buku (id_buku, tanggal_terima, no_induk, judul_buku, pengarang, penerbit, no_kelas, eksamplar, jenis, keterangan, harga) VALUES (
        '$id_buku_format',
        '" . $_POST['tanggal_terima'] . "',
        '$no_induk_baru',
        '" . $_POST['judul_buku'] . "',
        '" . $_POST['pengarang'] . "',
        '" . $_POST['penerbit'] . "',
        '" . $_POST['no_kelas'] . "',
        '" . $_POST['eksamplar'] . "',
        '" . $_POST['jenis'] . "',
        '" . $_POST['keterangan'] . "',
        '" . $_POST['harga'] . "'
    )";

  $query_simpan = mysqli_query($koneksi, $sql_simpan);

  // Menutup koneksi database
  mysqli_close($koneksi);

  // Notifikasi hasil penyimpanan
  if ($query_simpan) {
    echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil', text: '', icon: 'success', confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=MyApp/data_buku';
            }
        })</script>";
  } else {
    echo "<script>
        Swal.fire({title: 'Tambah Data Gagal', text: '', icon: 'error', confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=MyApp/add_buku';
            }
        })</script>";
  }
}
?>

<!-- HTML Form untuk Menambahkan Buku -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Buku</h3>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <!-- Kolom Kiri -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>ID Buku</label>
                  <input type="text" name="id_buku" id="id_buku" class="form-control" readonly />
                </div>

                <div class="form-group">
                  <label for="tanggal_terima">Tanggal Terima</label>
                  <input type="date" name="tanggal_terima" id="tanggal_terima" class="form-control" placeholder="YYYY-MM-DD" pattern="\d{4}-\d{2}-\d{2}" required>
                </div>

                <div class="form-group">
                  <label>No Induk</label>
                  <input type="text" name="no_induk" id="no_induk" class="form-control" readonly />
                </div>

                <div class="form-group">
                  <label>Judul Buku</label>
                  <input type="text" name="judul_buku" id="judul_buku" class="form-control" placeholder="Judul Buku" required>
                </div>

                <div class="form-group">
                  <label>Pengarang</label>
                  <input type="text" name="pengarang" id="pengarang" class="form-control" placeholder="Nama Pengarang" required>
                </div>
              </div>
              <!-- /.col-md-6 -->

              <!-- Kolom Kanan -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Penerbit</label>
                  <input type="text" name="penerbit" id="penerbit" class="form-control" placeholder="Penerbit" required>
                </div>

                <div class="form-group">
                  <label>No Kelas</label>
                  <input type="number" name="no_kelas" id="no_kelas" class="form-control" placeholder="No kelas" required>
                </div>

                <div class="form-group">
                  <label>Eksampler</label>
                  <input type="number" name="eksamplar" id="eksamplar" class="form-control" placeholder="Eksampler" required>
                </div>

                <div class="form-group">
                  <label>Jenis</label>

                  <select name="jenis" id="jenis" class="form-control" required>
                    <option value="">Pilih Jenis</option>
                    <option value="F">F</option>
                    <option value="NF">NF</option>
                    <option value="R">R</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Sumber buku" required>
                </div>

                <div class="form-group">
                  <label>Harga</label>
                  <input type="number" name="harga" id="harga" class="form-control" placeholder="Harga" required>
                </div>
              </div>
              <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
            <a href="?page=MyApp/data_buku" class="btn btn-warning">Batal</a>
          </div>
        </form>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>

<script>
  // Fungsi untuk memperbarui No Induk dan ID Buku secara otomatis saat memilih tanggal
function updateIdAndNoInduk() {
  const tanggalTerima = document.getElementById('tanggal_terima').value;
  const tahun = tanggalTerima ? tanggalTerima.split('-')[0].slice(2, 4) : '';

  if (tahun) {
    // Melakukan Ajax untuk mendapatkan data terakhir berdasarkan tahun ke halaman yang sama (index.php)
    fetch(`index.php?page=MyApp/add_buku_baru&tanggal_terima=${tanggalTerima}`)
      .then(response => {
        // Pastikan respons adalah JSON
        if (!response.ok) {
          throw new Error("Gagal memuat data dari server.");
        }
        return response.json();
      })
      .then(data => {
        // Periksa apakah data valid
        if (data && data.no_induk_baru && data.id_buku_baru) {
          document.getElementById('id_buku').value = data.id_buku_baru;
          document.getElementById('no_induk').value = data.no_induk_baru;
        } else {
          console.error("Data tidak ditemukan atau format JSON salah.");
        }
      })
      .catch(error => {
        console.error("Terjadi kesalahan dalam mengambil data: ", error);
      });
  }
}

// Memantau perubahan pada tanggal terima
document.getElementById('tanggal_terima').addEventListener('change', updateIdAndNoInduk);

</script>