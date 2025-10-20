// === POPUP HANDLER ===
const popupInfo = document.getElementById("popup-info");
const popupKonsultasi = document.getElementById("popup-konsultasi");
const closeButtons = document.querySelectorAll(".popup .close");

// Tombol di sidebar
document.getElementById("btnTentang").addEventListener("click", (e) => {
    e.preventDefault();
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
//  🔹 FITUR NILAI TAMBAH: Web Storage + Fetch + Promise + Async
// ===========================================================

// Simpan preferensi user (Web Storage)
if (!localStorage.getItem("userName")) {
    localStorage.setItem("userName", "Petani Hebat");
}
document.querySelector(".navbar--dashboard p").innerText = 
    `Selamat datang, ${localStorage.getItem("userName")} 👋`;

// Asynchronous + Fetch API: ambil data harga dari JSON dummy
const hargaList = document.getElementById("hargaList");
document.getElementById("btnHarga").addEventListener("click", async (e) => {
    e.preventDefault();

    hargaList.innerHTML = "<p>Sedang memuat data...</p>";

    // DATA DUMMY LOKAL BARU
    const dummyData = {
        "harga": [
            {"nama": "Cabai Merah Keriting", "harga": "45.000 / kg"},
            {"nama": "Bawang Merah", "harga": "32.500 / kg"},
            {"nama": "Beras Premium", "harga": "14.200 / kg"},
            {"nama": "Telur Ayam Ras", "harga": "27.000 / kg"}
        ]
    };

    try {
        // Gunakan Promise untuk simulasi delay, tapi fetch dihilangkan
        const data = await new Promise((resolve) => {
            setTimeout(() => {
                // Resolusi langsung ke dummyData
                resolve(dummyData); 
            }, 1200);
        });

        hargaList.innerHTML = "";
        data.harga.forEach(item => {
            const div = document.createElement("div");
            div.className = "harga-item";
            div.innerHTML = `<span>${item.nama}</span> <strong>Rp ${item.harga}</strong>`;
            hargaList.appendChild(div);
        });

        toast.innerText = "Data harga berhasil dimuat!";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 2000);

    } catch (err) {
        // Blok ini sekarang hampir tidak mungkin dicapai, karena tidak ada lagi kegagalan jaringan
        hargaList.innerHTML = `<p style="color:red;">Gagal memuat data harga.</p>`;
        console.error(err);
    }
});
