const navbar = document.getElementsByTagName("nav")[0];
const toggler = document.querySelector(".navbar-toggler");

// Fungsi untuk mengubah warna navbar berdasarkan scroll
function handleScroll() {
  if (window.innerWidth > 992) {
    // Hanya berjalan di desktop
    if (window.scrollY >= 1) {
      navbar.classList.add("scrolled");
      navbar.classList.replace("navbar-dark", "navbar-light");
    } else {
      navbar.classList.remove("scrolled");
      navbar.classList.replace("navbar-light", "navbar-dark");
    }
  }
}

// Fungsi untuk mengubah warna navbar saat toggler ditekan
function handleToggle() {
  if (window.innerWidth <= 992) {
    // Hanya berjalan di mobile
    navbar.classList.toggle("scrolled");
    navbar.classList.toggle("navbar-light");
    navbar.classList.toggle("navbar-dark");
  }
}

// Event listener untuk scroll
window.addEventListener("scroll", handleScroll);

// Event listener untuk toggler klik
toggler.addEventListener("click", handleToggle);

function showService(service) {
  const perpustakaanSection = document.getElementById("perpustakaan");
  const kearsipanSection = document.getElementById("kearsipan");

  // Menampilkan atau menyembunyikan bagian berdasarkan layanan yang dipilih
  if (service === "perpustakaan") {
    perpustakaanSection.style.display = "flex"; // Tampilkan bagian perpustakaan
    kearsipanSection.style.display = "none"; // Sembunyikan bagian kearsipan
  } else if (service === "kearsipan") {
    perpustakaanSection.style.display = "none"; // Sembunyikan bagian perpustakaan
    kearsipanSection.style.display = "flex"; // Tampilkan bagian kearsipan
  }

  // Menambahkan kelas 'active' pada tombol yang ditekan
  const buttons = document.querySelectorAll(".service-navigation button");
  buttons.forEach((button) => button.classList.remove("active"));
  const activeButton = document.querySelector(
    `button[onclick="showService('${service}')"]`
  );
  if (activeButton) {
    activeButton.classList.add("active");
  }
}
