@extends('layouts.app')

@section('title', 'Sampaikan Aspirasi Desa Anda')

@section('content')
<div class="row align-items-center min-vh-100">
    <div class="col-lg">
        <h1 class="display-4 fw-bold text-primary mb-4">
            Sampaikan <span class="text-success">Aspirasi</span><br>
            Desa Anda dalam <span class="display-2">1 Menit!</span>
        </h1>
        <p class="lead mb-4">
            Laporkan jalan rusak, banjir, lampu mati langsung ke perangkat desa.
            <strong>Tidak perlu surat atau antri!</strong>
        </p>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-3">
                    <i class="bi bi-speedometer2 display-4 text-primary"></i>
                    <h5>Lebih Cepat</h5>
                    <small>7 hari → 1 menit</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-3">
                    <i class="bi bi-camera display-4 text-success"></i>
                    <h5>Foto Bukti</h5>
                    <small>Upload langsung</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-3">
                    <i class="bi bi-check-circle display-4 text-success"></i>
                    <h5>Transparan</h5>
                    <small>Lihat status real-time</small>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 d-md-flex">
            @if(!Auth::check())
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-md-2">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </a>
                <a href="{{ route('register') }}" class="btn btn-success btn-lg px-4">
                    <i class="bi bi-person-plus"></i> Daftar Gratis
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
