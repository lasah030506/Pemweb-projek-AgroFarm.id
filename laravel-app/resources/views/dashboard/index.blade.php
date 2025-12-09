@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 30px;">
        <h2 style="font-size: 1.8rem; color: #2c3e50; font-weight: 700; margin-bottom: 5px;">Layanan AgroFarm</h2>
        <p style="color: #7f8c8d; font-size: 1rem;">Silakan pilih layanan untuk melanjutkan:</p>
    </div>

    <div class="services">
        <!-- Widget 1: Konsultasi -->
        <div class="service-box" style="background: rgba(255, 255, 255, 0.8);">
            <i class="fas fa-headset" style="background: #e8f5e9; color: #2ecc71;"></i>
            <div>
                <h3>Konsultasi Online</h3>
                <p>Tanya pakar pertanian.</p>
            </div>
        </div>

        <!-- Widget 2: Harga Pasar -->
        <div class="service-box" onclick="window.location='{{ route('commodities.index') }}'" style="background: rgba(255, 255, 255, 0.8); cursor: pointer;">
            <i class="fas fa-money-bill-wave" style="background: #fff3e0; color: #e67e22;"></i>
            <div>
                <h3>Harga Pasar</h3>
                <p>Update harga terbaru.</p>
            </div>
        </div>

        <!-- Widget 3: Pelatihan -->
        <div class="service-box" style="background: rgba(255, 255, 255, 0.8);">
            <i class="fas fa-chalkboard-teacher" style="background: #e1f5fe; color: #2980b9;"></i>
            <div>
                <h3>Pelatihan Petani</h3>
                <p>Ikuti kelas intensif.</p>
            </div>
        </div>

        <!-- Widget 4: Artikel -->
        <div class="service-box" style="background: rgba(255, 255, 255, 0.8);">
            <i class="fas fa-newspaper" style="background: #f3e5f5; color: #9b59b6;"></i>
            <div>
                <h3>Artikel Edukasi</h3>
                <p>Tips & inovasi tani.</p>
            </div>
        </div>
    </div>

    <!-- Data Harga Pasar Section -->
    <div class="harga-section" style="background: rgba(255, 255, 255, 0.8); border: none; padding: 30px; border-radius: 20px;">
        <h2 style="font-size: 1.5rem; color: #2ecc71; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-chart-line"></i> Data Harga Pasar
        </h2>
        
        <button class="btn-action" style="background: #3498db; color: white; margin-bottom: 15px; border-radius: 20px; font-size: 0.9rem; padding: 8px 20px;">
            <i class="fas fa-print"></i> Cetak PDF
        </button>

        <p style="color: #555;">Klik menu <strong>"Harga Pasar"</strong> di samping untuk memuat data terbaru.</p>
    </div>

@endsection
