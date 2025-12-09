@extends('layouts.app')

@section('content')
    <div class="harga-section" style="max-width: 600px; margin: 0 auto;">
        <h2><i class="fas fa-edit"></i> Edit Komoditas</h2>
        
        <form action="{{ route('commodities.update', $commodity->id) }}" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Komoditas</label>
                <input type="text" name="name" value="{{ $commodity->name }}" required 
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Satuan</label>
                <input type="text" name="unit" value="{{ $commodity->unit }}" required 
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga (Rp)</label>
                <input type="number" name="price" value="{{ $commodity->price }}" required 
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Gambar Saat Ini</label>
                @if($commodity->image_path)
                    <img src="{{ asset($commodity->image_path) }}" alt="Current" style="height: 80px; border-radius: 10px; margin-bottom: 10px;">
                @endif
                <input type="file" name="image" accept="image/*" 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 10px; background: #fff;">
                <small style="display: block; color: #666; margin-top: 5px;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <a href="{{ route('commodities.index') }}" class="btn-action btn-cancel" style="text-align: center;">Batal</a>
                <button type="submit" class="btn-action btn-add">Update Data</button>
            </div>
        </form>
    </div>
@endsection
