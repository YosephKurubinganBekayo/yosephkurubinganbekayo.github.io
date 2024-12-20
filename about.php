<?php
require 'call_fungtion.php';
if (!file_exists(__FILE__)) {
    header("Location: halaman_eror.php");
    exit();
}

// include "admin/inc/koneksi.php";
// Tangkap ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Query data berdasarkan ID dengan MySQLi
    $stmt = $koneksi->prepare("SELECT * FROM tbl_aboutus WHERE id_aboutus = ?");

    if ($stmt) {
        $stmt->bind_param("i", $id); // Bind parameter ID sebagai integer
        $stmt->execute();
        $result = $stmt->get_result();
        $about = $result->fetch_assoc();

        if ($about) {
            $title = htmlspecialchars($about['title_aboutus']);
            $detail = $about['detail_aboutus'];
            $image = htmlspecialchars($about['pict_aboutus']);
        } else {
            $title = 'Data Tidak Ditemukan';
            $detail = 'Halaman yang Anda cari tidak tersedia.';
            $image = '';
        }
        $stmt->close();
    } else {
        die("Query gagal: " . $koneksi->error);
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<?php include "head.php" ?>

<body>
    <!-- Topbar Start -->
    <?php include "topbar.php" ?>
    <!-- Topbar End -->
    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
        <?php include "navbar.php" ;
                if (!empty($id)) {

        ?>
        <!-- Header Start -->
        <style>
            .bg-breadcrumb {
                position: relative;
                overflow: hidden;
                background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                    url(img/<?php echo $image; ?>);
                background-position: center center;
                background-repeat: no-repeat;
                background-size: cover;
                padding: 140px 0 60px 0;
                transition: 0.5s;
            }
        </style>
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Tentang Kami</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active text-primary">Tentang Kami</li>
                    <li class="breadcrumb-item active text-primary"><?php echo $title; ?></li>
                </ol>
            </div>
        </div>
        <!-- Header End -->
    </div>
    <!-- Abaout Start -->
    <div id="about" class="container-fluid about py-5 ">
        <div class="container py-5">
            <?php
            $gambar_di_detail = ambil_gambar($id);
            if (!empty($gambar_di_detail)) { ?>
                <div class="row g-5 align-items-center">
                    <div class="col-xl-12 wow fadeInLeft" data-wow-delay="0.2s">
                        <?php echo ambil_isi($id); ?>
                    <?php } else {
                    echo $detail;
                } ?>
                    </div>
                </div>
                <?php
                $gambar_di_detail = ambil_gambar($id);
                if (!empty($gambar_di_detail)) { ?>
                    <div class="col-xl-12 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="rounded-start rounded-bottom position-center overflow-hidden d-flex justify-content-center">
                            <img src="<?php echo ambil_gambar($id)?>" class="img-fluid align-items-center"  alt="" />
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php } else {
            include "eror.php";
        } ?>
    <!-- About End -->
    <!-- Footer Start -->
    <?php include "footer.php" ?>
    <!-- Footer End -->
    <!-- Copyright Start -->

    <!-- Copyright End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>