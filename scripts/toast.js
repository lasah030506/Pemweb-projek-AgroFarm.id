// =====================================================
// TOAST / SNACKBAR TANPA FRAMEWORK
// =====================================================

// Buat elemen toast secara dinamis
const toast = document.createElement('div');
toast.id = 'toast';
toast.style.visibility = 'hidden';
toast.style.minWidth = '240px';
toast.style.backgroundColor = '#333';
toast.style.color = '#fff';
toast.style.textAlign = 'center';
toast.style.borderRadius = '8px';
toast.style.padding = '14px';
toast.style.position = 'fixed';
toast.style.zIndex = '9999';
toast.style.left = '50%';
toast.style.bottom = '40px';
toast.style.transform = 'translateX(-50%)';
toast.style.fontWeight = 'bold';
toast.style.opacity = '0';
toast.style.transition = 'opacity 0.5s ease';
document.body.appendChild(toast);

// Fungsi utama untuk menampilkan toast
function showToast(message, duration = 3000) {
  toast.textContent = message;
  toast.style.visibility = 'visible';
  toast.style.opacity = '1';

  setTimeout(() => {
    toast.style.opacity = '0';
  }, duration - 500);

  setTimeout(() => {
    toast.style.visibility = 'hidden';
  }, duration);
}

// =====================================================
// Contoh penggunaan otomatis saat halaman dibuka
// =====================================================
document.addEventListener('DOMContentLoaded', () => {
  showToast("Selamat datang di AgroFarm 🌾");
});

// =====================================================
// Contoh tambahan: panggil toast manual dari tombol
// =====================================================
// Misalnya di HTML kamu punya tombol <button onclick="showToast('Data berhasil disimpan!')">Klik</button>
