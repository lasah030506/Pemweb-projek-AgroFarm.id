@extends('layouts.app')

@section('content')
    <div class="harga-section" style="max-width: 600px; margin: 0 auto;">
        <h2><i class="fas fa-plus-circle"></i> Tambah Komoditas</h2>
        
        <form action="{{ route('commodities.store') }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
            @csrf
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Komoditas</label>
                <input type="text" name="name" required placeholder="Contoh: Beras Raja Lele" 
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Satuan</label>
                <input type="text" name="unit" required placeholder="Contoh: Kg, Liter" 
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga (Rp)</label>
                <input type="number" name="price" required placeholder="Contoh: 15000" 
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Gambar</label>
                <input type="file" name="image" accept="image/*" 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 10px; background: #fff;">
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <a href="{{ route('commodities.index') }}" class="btn-action btn-cancel" style="text-align: center;">Batal</a>
                <button type="submit" class="btn-action btn-add">Simpan Data</button>
            </div>
        </form>
    </div>
@endsection
