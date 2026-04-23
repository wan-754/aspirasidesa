@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="bi bi-house-door"></i>
        @if(Auth::user()->role == 'admin')
            Dashboard Admin Desa
        @else
            Aspirasi Saya
        @endif
    </h2>
    @if(isset($aspirasis) && $aspirasis->total())
        <span class="badge bg-primary fs-6">{{ $aspirasis->total() }} Aspirasi</span>
    @else
        <span class="badge bg-secondary fs-6">0 Aspirasi</span>
    @endif
</div>

@if(Auth::user()->role != 'admin')
<div class="card mb-4 shadow-lg border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Laporkan Masalah Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('aspirasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-7">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Masalah</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               name="title" value="{{ old('title') }}" placeholder="Contoh: Jalan rusak di RT 03" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description" rows="4" placeholder="Lokasi detail, kapan terjadi, dampak..." required>{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Bukti</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror"
                               name="photo" accept="image/*">
                        <div class="form-text">Max 2MB, JPG/PNG</div>
                        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-lg px-5">
                <i class="bi bi-send"></i> Kirim Aspirasi
            </button>
        </form>
    </div>
</div>
@endif

<div class="card shadow-lg border-0">
    <div class="card-header bg-light border-0">
        <h5 class="mb-0 d-flex justify-content-between align-items-center">
            <span><i class="bi bi-list-nested"></i> Daftar Aspirasi</span>
            <span class="badge bg-primary">{{ $aspirasis->total() }}</span>
        </h5>
    </div>
     @if(isset($aspirasis) && $aspirasis->count() > 0)
        <div class="list-group list-group-flush">
            @foreach($aspirasis as $aspirasi)
            <div class="list-group-item px-4 py-4">
                <div class="row align-items-start g-3">
                    <div class="col-md-1 text-center">
                        @if($aspirasi->photo)
                        <img src="{{ Storage::url($aspirasi->photo) }}"
                             class="rounded shadow-sm img-fluid"
                             style="width: 80px; height: 80px; object-fit: cover;"
                             alt="Bukti">
                        @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-image text-muted fs-1"></i>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h6 class="mb-2 fw-bold">{{ $aspirasi->title }}</h6>
                        <p class="text-muted mb-2">{{ Str::limit($aspirasi->description, 120) }}</p>

                        <div class="d-flex gap-2 flex-wrap mb-2">
                            <span class="badge
                                @if($aspirasi->status == 'pending') bg-warning
                                @elseif($aspirasi->status == 'processed') bg-info
                                @else bg-success @endif">
                                {{ ucfirst($aspirasi->status ?? 'pending') }}
                            </span>
                            <small class="text-muted align-self-center">
                                {{ $aspirasi->created_at->diffForHumans() }}
                            </small>
                        </div>

                        @if($aspirasi->reply)
                        <div class="alert alert-success p-2 mb-0 small">
                            <i class="bi bi-check-circle"></i>
                            {{ Str::limit($aspirasi->reply, 100) }}
                        </div>
                        @endif
                    </div>
                    <div class="col-md-3 text-end">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-person-circle"></i>
                            {{ $aspirasi->user->name }}
                        </small>
                        @if(auth()->user()->role === 'admin' && !$aspirasi->reply)
                        <form action="/aspirasi/{{ $aspirasi->id }}/reply" method="POST" class="d-inline">
                            @csrf
                            <textarea name="reply" class="form-control form-control-sm mb-1"
                                      rows="2" placeholder="Balas warga..." required></textarea>
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-reply"></i> Balas
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card-footer bg-light py-3">
            {{ $aspirasis->appends(request()->query())->links() }}
        </div>

    @else
        <div class="text-center py-5 my-5">
            <div class="display-1 text-muted mb-4 opacity-75">📭</div>
            <h4 class="text-muted mb-3">Belum ada aspirasi</h4>
            @if(auth()->user()->role !== 'admin')
            <p class="lead text-muted mb-4">Mulai dengan melaporkan masalah desa pertama!</p>
            <a href="#" class="btn btn-success btn-lg px-4">
                <i class="bi bi-plus-circle"></i> Buat Aspirasi
            </a>
            @endif
        </div>
    @endif
</div>
@endsection
