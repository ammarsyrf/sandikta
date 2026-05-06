@extends('layouts.app')
@section('title', 'Dashboard - Perpus Sandikta')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card animate-fadeInUp delay-1">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon bg-gradient-blue"><i class="bi bi-journal-richtext"></i></div>
            </div>
            <div class="stat-value">{{ $totalEbooks }}</div>
            <div class="stat-label">Total eBook Tersedia</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card animate-fadeInUp delay-2">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon bg-gradient-emerald"><i class="bi bi-book"></i></div>
            </div>
            <div class="stat-value">{{ $totalRead }}</div>
            <div class="stat-label">eBook Telah Dibaca</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card animate-fadeInUp delay-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon bg-gradient-purple"><i class="bi bi-person-circle"></i></div>
            </div>
            <div class="stat-value">{{ Auth::user()->kelas ?? '-' }}</div>
            <div class="stat-label">Kelas</div>
        </div>
    </div>
</div>

<!-- Reading History -->
@if($readingHistories->count() > 0)
<div class="card-modern mb-4 animate-fadeInUp delay-2">
    <div class="card-header">
        <h6><i class="bi bi-clock-history me-2 text-primary"></i>Terakhir Dibaca</h6>
    </div>
    <div class="card-body p-0">
        @foreach($readingHistories as $history)
        <div class="d-flex align-items-center gap-3 px-4 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
            <div style="width:48px;height:64px;border-radius:10px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="bi bi-file-earmark-pdf" style="color:#1e40af;font-size:22px"></i>
            </div>
            <div class="flex-grow-1">
                <div style="font-weight:600;font-size:14px">{{ $history->ebook->title }}</div>
                <div style="font-size:12px;color:#94a3b8">{{ $history->ebook->category?->name }} • Dibaca {{ $history->read_count }}x</div>
            </div>
            <div class="text-end">
                <div style="font-size:11px;color:#94a3b8">{{ $history->last_read_at?->diffForHumans() }}</div>
                <a href="{{ route('ebooks.read', $history->ebook) }}" class="btn btn-sm btn-primary-modern mt-1" style="padding:4px 14px;font-size:12px">Baca</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Recent eBooks -->
<div class="card-modern animate-fadeInUp delay-3">
    <div class="card-header">
        <h6><i class="bi bi-stars me-2 text-warning"></i>eBook Terbaru</h6>
        <a href="{{ route('ebooks.index') }}" class="btn btn-sm btn-outline-modern">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="row g-4">
            @forelse($recentEbooks as $ebook)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card-modern h-100" style="transition:all .3s" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 15px 35px rgba(30,64,175,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <div style="height:280px;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#0f172a;padding:15px;border-bottom:1px solid #f1f5f9">
                        @if($ebook->cover_image)
                        <!-- Blurred background for depth -->
                        <div style="position:absolute;top:0;left:0;right:0;bottom:0;background-image:url('{{ asset('storage/'.$ebook->cover_image) }}');background-size:cover;background-position:center;filter:blur(12px) opacity(0.25);transform:scale(1.15)"></div>
                        <!-- Main sharp cover image -->
                        <img src="{{ asset('storage/'.$ebook->cover_image) }}" style="max-width:100%;max-height:100%;object-fit:contain;position:relative;z-index:1;box-shadow:0 6px 16px rgba(0,0,0,0.35);border-radius:4px" alt="">
                        @else
                        <!-- Beautiful CSS Book Cover Fallback with Book Title -->
                        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;width:100%;padding:20px;text-align:center;color:white;background:linear-gradient(135deg, #1e3a8a, #3b82f6)">
                            <i class="bi bi-journal-text mb-2" style="font-size:32px;opacity:0.8"></i>
                            <span style="font-size:12px;font-weight:700;line-height:1.25;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;text-transform:capitalize">{{ $ebook->title }}</span>
                        </div>
                        @endif
                        <div style="position:absolute;top:12px;right:12px;z-index:10">
                            <span class="badge-modern badge-info">{{ $ebook->category?->name }}</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column" style="padding:20px">
                        <h6 style="font-weight:700;font-size:15px;margin-bottom:6px">{{ Str::limit($ebook->title, 40) }}</h6>
                        <p style="font-size:13px;color:#64748b;margin-bottom:4px"><i class="bi bi-person me-1"></i>{{ $ebook->author }}</p>
                        @if($ebook->kelas_tujuan)
                        <p style="font-size:12px;color:#94a3b8;margin-bottom:12px"><i class="bi bi-mortarboard me-1"></i>{{ $ebook->kelas_tujuan }}</p>
                        @endif
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('ebooks.show', $ebook) }}" class="btn btn-outline-modern flex-grow-1" style="font-size:13px;padding:8px">Detail</a>
                            <a href="{{ route('ebooks.read', $ebook) }}" class="btn btn-primary-modern flex-grow-1" style="font-size:13px;padding:8px"><i class="bi bi-book me-1"></i>Baca</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="bi bi-journal-x" style="font-size:48px;opacity:0.3"></i>
                <p class="mt-2">Belum ada eBook tersedia</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
