// =====================================================
// DOM 1: Ubah teks hero otomatis setiap 3 detik
// =====================================================
const heroText = document.querySelector('.hero h1');
setInterval(() => {
  if (heroText) {
    heroText.textContent = 
      (heroText.textContent === "Selamat Datang di AgroFarm.id")
      ? "Mari Majukan Pertanian Digital!"
      : "Selamat Datang di AgroFarm.id";
  }
}, 3000);


// =====================================================
// DOM 2: Tampilkan waktu real-time di footer
// =====================================================
const footer = document.querySelector('.site-footer');
if (footer) {
  const timeDisplay = document.createElement('p');
  timeDisplay.style.marginTop = '10px';
  timeDisplay.style.fontWeight = '600';
  footer.appendChild(timeDisplay);

  setInterval(() => {
    const now = new Date();
    timeDisplay.textContent = "Waktu sekarang: " + now.toLocaleTimeString();
  }, 1000);
}


// =====================================================
// DOM 3: Ganti warna navbar saat scroll
// =====================================================
window.addEventListener('scroll', () => {
  const navbar = document.querySelector('.navbar');
  if (navbar) {
    if (window.scrollY > 50) {
      navbar.style.background = "#1b6a36";
    } else {
      navbar.style.background = "#024D1E";
    }
  }
});


// =====================================================
// TOAST / SNACKBAR TANPA FRAMEWORK
// =====================================================

// Buat elemen toast secara dinamis
const toast = document.createElement('div');
toast.id = 'toast';
toast.style.visibility = 'hidden';
toast.style.minWidth = '250px';
toast.style.backgroundColor = '#333';
toast.style.color = '#fff';
toast.style.textAlign = 'center';
toast.style.borderRadius = '8px';
toast.style.padding = '16px';
toast.style.position = 'fixed';
toast.style.zIndex = '100';
toast.style.left = '50%';
toast.style.bottom = '30px';
toast.style.transform = 'translateX(-50%)';
toast.style.fontWeight = 'bold';
document.body.appendChild(toast);

// Fungsi untuk menampilkan toast
function showToast(message) {
  toast.textContent = message;
  toast.style.visibility = 'visible';
  toast.style.opacity = '1';
  toast.style.transition = 'opacity 0.5s';

  setTimeout(() => {
    toast.style.opacity = '0';
  }, 2500);

  setTimeout(() => {
    toast.style.visibility = 'hidden';
  }, 3000);
}

// Tampilkan toast otomatis saat halaman dibuka
document.addEventListener('DOMContentLoaded', () => {
  showToast("Selamat datang di AgroFarm.id 🌾");
});
