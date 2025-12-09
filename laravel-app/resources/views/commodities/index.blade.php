@extends('layouts.app')

@section('content')
    <div class="harga-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2><i class="fas fa-list"></i> Daftar Harga Komoditas</h2>
            <div style="display: flex; gap: 10px;">
                 <button class="btn-action btn-print" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
                <a href="{{ route('commodities.create') }}" class="btn-action btn-add">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        </div>

        <div class="harga-list">
            @foreach($commodities as $commodity)
            <div class="harga-item">
                <div style="display: flex; align-items: center; gap: 15px;">
                    @if($commodity->image_path)
                        <img src="{{ asset($commodity->image_path) }}" alt="{{ $commodity->name }}" style="width: 60px; height: 60px; border-radius: 12px; object-fit: cover;">
                    @else
                        <div style="width: 60px; height: 60px; background: #eee; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #aaa;">
                            <i class="fas fa-image" style="font-size: 24px;"></i>
                        </div>
                    @endif
                    <div>
                        <h3 style="margin: 0; font-size: 1.1rem; color: var(--text-dark);">{{ $commodity->name }}</h3>
                        <p style="margin: 4px 0 0 0; color: var(--text-muted); font-size: 0.9rem;">
                            {{ $commodity->unit }} • Update: {{ $commodity->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <div style="text-align: right; display: flex; align-items: center; gap: 20px;">
                    <div>
                        <span style="display: block; font-size: 0.8rem; color: var(--text-muted);">Harga Sekarang</span>
                        <span style="font-size: 1.2rem; font-weight: bold; color: var(--primary-green);">
                            Rp {{ number_format($commodity->price, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <div style="display: flex; gap: 8px;">
                         <a href="{{ route('commodities.edit', $commodity->id) }}" style="color: var(--accent-orange); font-size: 1.2rem;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('commodities.destroy', $commodity->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #e74c3c; font-size: 1.2rem; cursor: pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            @if($commodities->isEmpty())
             <div class="harga-item" style="justify-content: center; padding: 40px;">
                <div style="text-align: center; color: var(--text-muted);">
                    <i class="fas fa-leaf" style="font-size: 3rem; margin-bottom: 10px; color: #ddd;"></i>
                    <p>Belum ada data komoditas.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
