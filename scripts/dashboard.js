// === POPUP HANDLER ===
const popupInfo = document.getElementById("popup-info");
const popupKonsultasi = document.getElementById("popup-konsultasi");
const closeButtons = document.querySelectorAll(".popup .close");

// Sidebar: Tentang AgroFarm
document.getElementById("btnTentang").addEventListener("click", (e) => {
    e.preventDefault();
    popupInfo.querySelector('h2').innerText = "Tentang AgroFarm";
    popupInfo.querySelector('p').innerHTML = "AgroFarm.id adalah platform digital untuk mendukung petani dan peternak Indonesia dalam menghadapi era pertanian modern.";
    popupInfo.style.display = "flex";
});

// Tutup popup
closeButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        popupInfo.style.display = "none";
        popupKonsultasi.style.display = "none";
    });
});

window.addEventListener("click", (e) => {
    if (e.target === popupInfo) popupInfo.style.display = "none";
    if (e.target === popupKonsultasi) popupKonsultasi.style.display = "none";
});

// Popup Konsultasi Online
document.getElementById("boxKonsultasi").addEventListener('click', () => {
    popupKonsultasi.style.display = "flex";
});

// === TOAST ===
const toast = document.getElementById("toast");
document.querySelectorAll('.service-box').forEach(box => {
    box.addEventListener('mouseover', () => {
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 1500);
    });
});

// === SCROLL NAVBAR ===
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar--dashboard');
    navbar.classList.toggle('shrink', window.scrollY > 50);
});

// ===========================================================
//  🔹 FITUR HARGA (Final Fix)
// ===========================================================
const hargaList = document.getElementById("hargaList");

// Tombol Sidebar: Harga Pasar
document.getElementById("btnHarga").addEventListener("click", (e) => {
    e.preventDefault();
    loadHargaPasar();
});

// Tombol Box Dashboard: Harga Pasar
const boxHarga = document.getElementById("boxHarga");
if (boxHarga) {
    boxHarga.addEventListener("click", () => {
        loadHargaPasar();
        document.querySelector('.harga-section').scrollIntoView({ behavior: 'smooth' });
    });
}

async function loadHargaPasar() {
    hargaList.innerHTML = "<p style='text-align:center; padding:10px;'>Sedang mengambil data terbaru...</p>";

    try {
        const response = await fetch('get_commodities.php');
        if (!response.ok) throw new Error("Server error");

        const data = await response.json();
        hargaList.innerHTML = "";

        if (data.length === 0) {
            hargaList.innerHTML = `
                <div style="text-align:center; padding:20px; background:#f9f9f9; border-radius:8px;">
                    <i class="fa-solid fa-basket-shopping" style="font-size:30px; color:#ccc; margin-bottom:10px;"></i>
                    <p>Belum ada data harga pasar saat ini.</p>
                </div>`;
            return;
        }

        data.forEach(item => {
            const div = document.createElement("div");
            div.className = "harga-item";

            // Handle Gambar
            let imgHtml = '';
            if (item.image_path) {
                // Pastikan path gambar benar relatif dari dashboard.php (masuk ke parent dulu)
                // Karena dashboard ada di src/, image di assets/ (sejajar src)
                // Maka path di DB biasanya 'assets/uploads/file.jpg'. Kita perlu tambah '../'
                imgHtml = `<img src="../${item.image_path}" style="width:50px; height:50px; border-radius:6px; object-fit:cover; margin-right:15px; border:1px solid #eee;">`;
            } else {
                imgHtml = `<div style="width:50px; height:50px; background:#e0e0e0; border-radius:6px; margin-right:15px; display:flex; align-items:center; justify-content:center; color:#999;"><i class="fa-solid fa-image"></i></div>`;
            }

            // Format Rupiah Real
            const price = parseFloat(item.price);
            const formattedPrice = new Intl.NumberFormat('id-ID').format(price);

            div.innerHTML = `
                <div style="display:flex; align-items:center;">
                    ${imgHtml}
                    <div>
                        <strong style="display:block; font-size:1.1em; color:#2c6e49;">${item.name}</strong>
                    </div>
                </div>
                <div style="text-align:right;">
                    <span style="display:block; font-size:0.9em; color:#777;">Harga Hari Ini</span>
                    <strong style="color:#e67e22; font-size:1.2em;">Rp ${formattedPrice}</strong> <small>/ ${item.unit}</small>
                </div>
            `;

            hargaList.appendChild(div);
        });

        toast.innerText = "Data pasar berhasil diperbarui!";
        toast.classList.add("show");
        setTimeout(() => toast.classList.remove("show"), 2000);

    } catch (err) {
        console.error("Error fetching data:", err);
        hargaList.innerHTML = `<p style="color:#c0392b; text-align:center;">Gagal memuat data. Periksa koneksi atau hubungi admin.</p>`;
    }
}

// === CETAK PDF ===
const btnPrintPDF = document.getElementById("btnPrintPDF");
if (btnPrintPDF) {
    btnPrintPDF.addEventListener("click", async () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Judul Dokumen
        doc.setFontSize(18);
        doc.text("Laporan Harga Pasar - AgroFarm.id", 14, 22);

        doc.setFontSize(11);
        doc.setTextColor(100);
        doc.text(`Dicetak pada: ${new Date().toLocaleString('id-ID')}`, 14, 30);

        // Ambil data terbaru dari Server
        try {
            const response = await fetch('get_commodities.php');
            const data = await response.json();

            if (data.length === 0) {
                alert("Tidak ada data untuk dicetak!");
                return;
            }

            // Format Data untuk AutoTable
            const tableData = data.map((item, index) => [
                index + 1,
                item.name,
                `Rp ${new Intl.NumberFormat('id-ID').format(item.price)}`,
                item.unit
            ]);

            // Generate Tabel
            doc.autoTable({
                startY: 40,
                head: [['No', 'Komoditas', 'Harga', 'Satuan']],
                body: tableData,
                theme: 'grid',
                headStyles: { fillColor: [46, 204, 113] }, // Warna Hijau AgroFarm
                styles: { fontSize: 10, cellPadding: 3 },
            });

            // Footer
            const finalY = doc.lastAutoTable.finalY + 10;
            doc.setFontSize(10);
            doc.text("© 2025 AgroFarm Indonesia", 14, finalY);

            // Download PDF
            doc.save(`Laporan_Harga_Pasar_${new Date().toISOString().slice(0, 10)}.pdf`);

            toast.innerText = "Laporan PDF berhasil diunduh!";
            toast.classList.add("show");
            setTimeout(() => toast.classList.remove("show"), 2000);

        } catch (error) {
            console.error(error);
            alert("Gagal mencetak PDF. Silakan coba lagi.");
        }
    });
}
