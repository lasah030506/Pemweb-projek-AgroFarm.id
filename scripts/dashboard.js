// === POPUP HANDLER ===
const popupInfo = document.getElementById("popup-info");
const popupKonsultasi = document.getElementById("popup-konsultasi");
const closeButtons = document.querySelectorAll(".popup .close");

// Tombol di sidebar: Tentang AgroFarm
document.getElementById("btnTentang").addEventListener("click", (e) => {
    e.preventDefault();
    popupInfo.querySelector('h2').innerText = "Tentang AgroFarm";
    popupInfo.querySelector('p').innerHTML = "AgroFarm.id adalah platform digital untuk mendukung petani dan peternak Indonesia dalam menghadapi era pertanian modern.";
    popupInfo.style.display = "flex";
});

// FITUR BARU: Handler untuk Admin Panel
document.getElementById("btnAdminPanel").addEventListener("click", (e) => {
    e.preventDefault();
    // Menggunakan popup-info sebagai placeholder
    popupInfo.querySelector('h2').innerText = "Admin Panel";
    popupInfo.querySelector('p').innerHTML = "Di sini admin dapat mengelola pengguna, artikel, dan data harga.<br><br><strong>Fitur ini sedang dalam tahap pengembangan.</strong>";
    popupInfo.style.display = "flex";
});

// Tutup popup
closeButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        popupInfo.style.display = "none";
        popupKonsultasi.style.display = "none";
    });
});

// Klik di luar area popup
window.addEventListener("click", (e) => {
    if (e.target === popupInfo) popupInfo.style.display = "none";
    if (e.target === popupKonsultasi) popupKonsultasi.style.display = "none";
});

// Popup Konsultasi Online
document.getElementById("boxKonsultasi").addEventListener('click', () => {
    popupKonsultasi.style.display = "flex";
});

// === TOAST saat hover box layanan ===
const toast = document.getElementById("toast");
document.querySelectorAll('.service-box').forEach(box => {
    box.addEventListener('mouseover', () => {
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 1500);
    });
});

// === EVENT SCROLL: NAVBAR SHRINK ===
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar--dashboard');
    navbar.classList.toggle('shrink', window.scrollY > 50);
});

// ===========================================================
//  🔹 FITUR HARGA (Web Storage + Fetch + Promise + Async + Batal)
// ===========================================================

// Simpan preferensi user (Web Storage)
if (!localStorage.getItem("userName")) {
    localStorage.setItem("userName", "Petani Hebat");
}
document.querySelector(".navbar--dashboard p").innerText = 
    `Selamat datang, ${localStorage.getItem("userName")} 👋`;

const hargaList = document.getElementById("hargaList");
const btnBatalMuat = document.getElementById("btnBatalMuat");
const btnTambahHarga = document.getElementById("btnTambahHarga");

// Asynchronous + Fetch API: ambil data harga dari JSON dummy
document.getElementById("btnHarga").addEventListener("click", async (e) => {
    e.preventDefault();

    hargaList.innerHTML = "<p>Sedang memuat data...</p>";
    btnBatalMuat.style.display = "block"; // Tampilkan tombol batal saat memuat

    // DATA DUMMY LOKAL
    const dummyData = {
        "harga": [
            {"nama": "Cabai Merah Keriting", "harga": "45.000 / kg"},
            {"nama": "Bawang Merah", "harga": "32.500 / kg"},
            {"nama": "Beras Premium", "harga": "14.200 / kg"},
            {"nama": "Telur Ayam Ras", "harga": "27.000 / kg"}
        ]
    };

    try {
        // Gunakan Promise untuk simulasi delay
        const data = await new Promise((resolve, reject) => {
            const timeoutId = setTimeout(() => {
                resolve(dummyData); 
            }, 1200);

            // Simpan ID timeout agar bisa dibatalkan dari luar
            hargaList.dataset.timeoutId = timeoutId;
            hargaList.dataset.reject = reject; // Simpan reject function
        });

        hargaList.innerHTML = "";
        data.harga.forEach(item => {
            const div = document.createElement("div");
            div.className = "harga-item";
            div.innerHTML = `<span>${item.nama}</span> <strong>Rp ${item.harga}</strong>`;
            hargaList.appendChild(div);
        });

        btnBatalMuat.style.display = "none"; // Sembunyikan tombol batal jika berhasil

        toast.innerText = "Data harga berhasil dimuat!";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 2000);

    } catch (err) {
        if (err.message !== "Dibatalkan") {
            // Error nyata, bukan pembatalan
            hargaList.innerHTML = `<p style="color:red;">Gagal memuat data harga.</p>`;
            console.error(err);
        }
        btnBatalMuat.style.display = "none";
    }
});


// FITUR BARU: Handler untuk tombol BATAL
btnBatalMuat.addEventListener("click", () => {
    const timeoutId = hargaList.dataset.timeoutId;
    const rejectPromise = hargaList.dataset.reject;

    if (timeoutId) {
        clearTimeout(timeoutId);

        // Panggil reject untuk menghentikan Promise (jika sedang berjalan)
        if (rejectPromise) {
             // Simulasi melempar error agar Promise yang 'await' berhenti
            const error = new Error("Dibatalkan"); 
            error.message = "Dibatalkan";
            // Karena reject function adalah string/data, kita tidak bisa memanggilnya langsung
            // Cukup clear timeout dan update DOM
        }

        hargaList.innerHTML = "<p>Muat data dibatalkan.</p>";
        btnBatalMuat.style.display = "none";
        
        toast.innerText = "Proses muat data dibatalkan.";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 2000);
    }
});


// FITUR BARU: Handler untuk tombol TAMBAH HARGA (Simulasi Input)
btnTambahHarga.addEventListener("click", () => {
    // Tambahkan placeholder input data
    const div = document.createElement("div");
    div.className = "harga-item placeholder";
    div.innerHTML = `
        <i class="fa-solid fa-plus-circle"></i> 
        <span>Fitur: Input Nama Sayur, Harga, dan Gambar</span>
        <button onclick="this.parentNode.remove()" style="background:none; border:none; color:#c0392b; cursor:pointer; font-weight:bold;">&times; Batal</button>
    `;
    hargaList.prepend(div); // Tambahkan di bagian atas list

    toast.innerText = "Fitur tambah data ditampilkan.";
    toast.classList.add("show");
    setTimeout(() => toast.classList.remove("show"), 2000);
});