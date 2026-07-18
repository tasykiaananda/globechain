@extends('layouts.app')

@section('content')
<div class="d-flex flex-column h-100" style="overflow:hidden;">

    <!-- Header -->
    <div class="d-flex align-items-center gap-2 mb-4 flex-shrink-0">
        <div>
            <h4 class="mb-0 fw-bold text-dark" style="letter-spacing:-0.5px;">Profil Pengguna</h4>
            <p class="text-secondary mb-0" style="font-size:0.85rem;"><i class="fa-solid fa-circle-user me-1"></i>Kelola informasi akun Anda.</p>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card-corporate p-4 text-center h-100">
                <!-- Avatar -->
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                     style="width:80px;height:80px;font-size:2rem;background:linear-gradient(135deg,#3d5fc0,#7ba7ff);">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ Auth::user()->name ?? '-' }}</h5>
                <span class="badge rounded-pill px-3 py-1" style="background:rgba(61,95,192,0.12);color:#3d5fc0;font-size:0.75rem;">
                    {{ ucfirst(Auth::user()->role ?? 'User') }}
                </span>
                <hr class="my-3">
                <div class="text-start">
                    <p class="mb-1 text-muted" style="font-size:0.75rem;text-transform:uppercase;font-weight:700;">Email</p>
                    <p class="fw-semibold text-dark" style="font-size:0.9rem;">{{ Auth::user()->email ?? '-' }}</p>
                    <p class="mb-1 text-muted mt-3" style="font-size:0.75rem;text-transform:uppercase;font-weight:700;">Bergabung Sejak</p>
                    <p class="fw-semibold text-dark" style="font-size:0.9rem;">{{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card-corporate p-4 h-100">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-pen-to-square me-2 text-secondary"></i>Informasi Akun</h6>
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size:0.78rem;font-weight:700;text-transform:uppercase;">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name ?? '' }}" readonly style="font-size:0.9rem;background:#f8fafc;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size:0.78rem;font-weight:700;text-transform:uppercase;">Peran / Role</label>
                            <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->role ?? 'User') }}" readonly style="font-size:0.9rem;background:#f8fafc;">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted" style="font-size:0.78rem;font-weight:700;text-transform:uppercase;">Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email ?? '' }}" readonly style="font-size:0.9rem;background:#f8fafc;">
                        </div>
                        <div class="col-12">
                            <div class="alert mb-0 d-flex align-items-center gap-2 py-2 px-3" style="background:#f0f4ff;border:1px solid #c7d8ff;border-radius:8px;font-size:0.82rem;color:#3d5fc0;">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>Untuk mengubah data profil, hubungi administrator sistem.</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
