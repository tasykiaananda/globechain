@extends('layouts.app')

@section('content')
    <style>
        /* ====== ADMIN PORTS - DARK NAVY THEME ====== */
        .admin-ports { display: flex; flex-direction: column; height: 100%; gap: 1rem; }

        .admin-ports .page-header {
            display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;
        }
        .admin-ports .page-header .title-group h3 {
            font-size: 1.3rem; font-weight: 800; color: #e2e8f0;
            margin-bottom: 0.1rem; letter-spacing: -0.5px;
        }
        .admin-ports .page-header .title-group p {
            font-size: 0.78rem; color: #94a3b8; margin: 0;
        }
        .admin-ports .btn-add-port {
            background: linear-gradient(135deg, #4f7ddb, #6b8ddb);
            color: #fff; border: none; padding: 0.55rem 1.2rem; border-radius: 10px;
            font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; gap: 0.45rem;
            transition: all 0.25s ease; cursor: pointer;
        }
        .admin-ports .btn-add-port:hover {
            transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79,125,219,0.35);
        }

        /* Search Bar */
        .admin-ports .search-bar {
            display: flex; gap: 0.6rem; align-items: center; flex-shrink: 0;
        }
        .admin-ports .search-bar input {
            flex: 1; background: #1a2744; border: 1.5px solid #2a3f66; color: #e2e8f0;
            border-radius: 10px; padding: 0.55rem 1rem; font-size: 0.8rem;
            transition: border-color 0.2s ease;
        }
        .admin-ports .search-bar input::placeholder { color: #64748b; }
        .admin-ports .search-bar input:focus { outline: none; border-color: #4f7ddb; background: #1e2f4f; }
        .admin-ports .search-bar .btn-search {
            background: linear-gradient(135deg, #4f7ddb, #3d5fc0); color: #fff; border: none;
            padding: 0.55rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: 0.8rem;
            display: flex; align-items: center; gap: 0.4rem; cursor: pointer;
            transition: all 0.2s ease;
        }
        .admin-ports .search-bar .btn-search:hover { box-shadow: 0 4px 15px rgba(79,125,219,0.3); }
        .admin-ports .search-bar .btn-reset {
            background: #1a2744; border: 1.5px solid #2a3f66; color: #94a3b8;
            padding: 0.55rem 1rem; border-radius: 10px; font-size: 0.8rem; font-weight: 600;
            text-decoration: none; display: flex; align-items: center; gap: 0.3rem;
            transition: all 0.2s ease;
        }
        .admin-ports .search-bar .btn-reset:hover { border-color: #ef4444; color: #f87171; }

        /* Alert Notif */
        .admin-ports .alert-navy {
            background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2);
            color: #4ade80; border-radius: 10px; padding: 0.7rem 1rem;
            font-size: 0.78rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;
            flex-shrink: 0;
        }
        .admin-ports .alert-danger-navy {
            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);
            color: #f87171; border-radius: 10px; padding: 0.7rem 1rem;
            font-size: 0.78rem; flex-shrink: 0;
        }

        /* Table Card */
        .admin-ports .table-card {
            background: #111d35; border-radius: 14px; border: 1px solid #1e3054;
            flex: 1; overflow: hidden; display: flex; flex-direction: column;
        }
        .admin-ports .table-card .table-scroll { flex: 1; overflow-y: auto; }
        .admin-ports .table-card table { width: 100%; border-collapse: collapse; }
        .admin-ports .table-card thead th {
            background: #0d1a30; color: #64748b; font-size: 0.68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px; padding: 0.75rem 1rem;
            border-bottom: 1px solid #1e3054; position: sticky; top: 0; z-index: 5;
        }
        .admin-ports .table-card tbody tr {
            border-bottom: 1px solid #1a2744; transition: background 0.2s ease;
        }
        .admin-ports .table-card tbody tr:hover { background: rgba(79,125,219,0.06); }
        .admin-ports .table-card tbody td {
            padding: 0.65rem 1rem; font-size: 0.8rem; color: #cbd5e1; vertical-align: middle;
        }
        .admin-ports .port-name {
            display: flex; align-items: center; gap: 0.7rem;
        }
        .admin-ports .port-icon {
            width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
            background: rgba(79,125,219,0.12); color: #4f7ddb;
            display: flex; align-items: center; justify-content: center; font-size: 0.75rem;
        }
        .admin-ports .port-name-text { font-weight: 600; color: #e2e8f0; }
        .admin-ports .coord-badge {
            font-size: 0.72rem; font-weight: 600; padding: 0.25rem 0.55rem;
            border-radius: 6px; background: rgba(100,116,139,0.15); color: #94a3b8;
            font-family: 'Courier New', monospace;
        }
        .admin-ports .country-tag {
            display: inline-flex; align-items: center; gap: 0.3rem;
            font-size: 0.78rem; color: #94a3b8;
        }
        .admin-ports .country-tag i { color: #4f7ddb; font-size: 0.65rem; }

        /* Action Buttons */
        .admin-ports .action-btns { display: flex; gap: 0.4rem; justify-content: flex-end; }
        .admin-ports .btn-act {
            width: 30px; height: 30px; border-radius: 8px; border: none;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; cursor: pointer; transition: all 0.2s ease;
        }
        .admin-ports .btn-edit { background: rgba(79,125,219,0.12); color: #4f7ddb; }
        .admin-ports .btn-edit:hover { background: #4f7ddb; color: #fff; }
        .admin-ports .btn-del { background: rgba(239,68,68,0.1); color: #f87171; }
        .admin-ports .btn-del:hover { background: #ef4444; color: #fff; }

        /* Pagination Bar */
        .admin-ports .pagination-bar {
            padding: 0.65rem 1rem; border-top: 1px solid #1e3054;
            display: flex; justify-content: space-between; align-items: center;
            background: #0d1a30; flex-shrink: 0;
        }
        .admin-ports .pagination-bar .page-info {
            font-size: 0.72rem; color: #64748b;
        }
        .admin-ports .pagination-bar .page-info strong { color: #cbd5e1; }
        .admin-ports .page-btns { display: flex; gap: 0.3rem; }
        .admin-ports .page-btns a, .admin-ports .page-btns span {
            padding: 0.35rem 0.7rem; border-radius: 7px; font-size: 0.72rem; font-weight: 600;
            text-decoration: none; transition: all 0.2s ease;
        }
        .admin-ports .page-btns a {
            background: #1a2744; color: #94a3b8; border: 1px solid #2a3f66;
        }
        .admin-ports .page-btns a:hover { background: #4f7ddb; color: #fff; border-color: #4f7ddb; }
        .admin-ports .page-btns span.active {
            background: #4f7ddb; color: #fff; border: 1px solid #4f7ddb;
        }
        .admin-ports .page-btns span.disabled {
            background: #0d1a30; color: #334155; border: 1px solid #1e3054; cursor: default;
        }

        /* Empty State */
        .admin-ports .empty-state {
            text-align: center; padding: 3rem; color: #475569;
        }
        .admin-ports .empty-state i { font-size: 2.5rem; color: #1e3054; margin-bottom: 0.8rem; display: block; }
        .admin-ports .empty-state p { font-size: 0.85rem; color: #64748b; }

        /* ====== MODAL DARK NAVY ====== */
        .modal-navy .modal-content {
            background: #111d35; border: 1px solid #1e3054; border-radius: 16px;
            color: #e2e8f0;
        }
        .modal-navy .modal-header { border-bottom: 1px solid #1e3054; padding: 1.2rem 1.5rem; }
        .modal-navy .modal-title { font-weight: 700; color: #e2e8f0; font-size: 1rem; }
        .modal-navy .btn-close { filter: invert(1); opacity: 0.5; }
        .modal-navy .modal-body { padding: 1.2rem 1.5rem; }
        .modal-navy .form-label {
            font-size: 0.7rem; font-weight: 700; color: #64748b;
            text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 0.3rem;
        }
        .modal-navy .form-control, .modal-navy .form-select {
            background: #1a2744; border: 1.5px solid #2a3f66; color: #e2e8f0;
            border-radius: 10px; padding: 0.6rem 0.9rem; font-size: 0.85rem;
        }
        .modal-navy .form-control::placeholder { color: #475569; }
        .modal-navy .form-control:focus, .modal-navy .form-select:focus {
            outline: none; border-color: #4f7ddb; box-shadow: 0 0 0 3px rgba(79,125,219,0.15);
            background: #1e2f4f;
        }
        .modal-navy .form-select option { background: #1a2744; color: #e2e8f0; }
        .modal-navy .modal-footer { border-top: 1px solid #1e3054; padding: 1rem 1.5rem; }
        .modal-navy .btn-cancel {
            background: transparent; border: 1.5px solid #2a3f66; color: #94a3b8;
            padding: 0.5rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: 0.8rem;
            cursor: pointer; transition: all 0.2s ease;
        }
        .modal-navy .btn-cancel:hover { border-color: #64748b; color: #e2e8f0; }
        .modal-navy .btn-save {
            background: linear-gradient(135deg, #4f7ddb, #3d5fc0); border: none; color: #fff;
            padding: 0.5rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.8rem;
            cursor: pointer; transition: all 0.2s ease;
        }
        .modal-navy .btn-save:hover { box-shadow: 0 4px 15px rgba(79,125,219,0.35); }
    </style>

    <div class="admin-ports" style="background: linear-gradient(180deg, #0d1e3d 0%, #0f2044 100%); margin: -1.25rem -1.5rem; padding: 1.25rem 1.5rem; height: calc(100% + 2.5rem);">

        {{-- Header --}}
        <div class="page-header">
            <div class="title-group">
                <h3><i class="fa-solid fa-anchor me-2" style="color: #4f7ddb;"></i>Dataset Pelabuhan</h3>
                <p>Kelola data World Port Index — {{ number_format($ports->total()) }} titik pelabuhan terdaftar.</p>
            </div>
            <button type="button" class="btn-add-port" data-bs-toggle="modal" data-bs-target="#addPortModal">
                <i class="fa-solid fa-plus"></i> Tambah Pelabuhan
            </button>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.ports') }}" class="search-bar">
            <input type="text" name="search" placeholder="Cari pelabuhan atau negara..." value="{{ request('search') }}">
            <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.ports') }}" class="btn-reset"><i class="fa-solid fa-xmark"></i> Reset</a>
            @endif
        </form>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert-navy">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert-danger-navy">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        {{-- Table --}}
        <div class="table-card">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Pelabuhan</th>
                            <th>Negara</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ports as $port)
                        <tr>
                            <td>
                                <div class="port-name">
                                    <div class="port-icon"><i class="fa-solid fa-anchor"></i></div>
                                    <span class="port-name-text">{{ $port->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="country-tag">
                                    <i class="fa-solid fa-location-dot"></i> {{ $port->country_name }}
                                </span>
                            </td>
                            <td><span class="coord-badge">{{ $port->lat }}</span></td>
                            <td><span class="coord-badge">{{ $port->lng }}</span></td>
                            <td>
                                <div class="action-btns">
                                    <button type="button" class="btn-act btn-edit" title="Edit"
                                        onclick="openEditPort({{ $port->id }}, '{{ addslashes($port->name) }}', {{ $port->country_id }}, {{ $port->lat }}, {{ $port->lng }})">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.ports.delete', $port->id) }}" method="POST" style="display:inline;"
                                        onsubmit="return confirm('Hapus pelabuhan {{ addslashes($port->name) }}?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-act btn-del" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fa-solid fa-ship"></i>
                                    <p>{{ request('search') ? 'Tidak ditemukan pelabuhan yang cocok.' : 'Belum ada data pelabuhan.' }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($ports->hasPages())
            <div class="pagination-bar">
                <div class="page-info">
                    Menampilkan <strong>{{ $ports->firstItem() }}-{{ $ports->lastItem() }}</strong> dari <strong>{{ number_format($ports->total()) }}</strong> pelabuhan
                </div>
                <div class="page-btns">
                    {{-- Previous --}}
                    @if($ports->onFirstPage())
                        <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
                    @else
                        <a href="{{ $ports->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach($ports->getUrlRange(max(1, $ports->currentPage()-2), min($ports->lastPage(), $ports->currentPage()+2)) as $page => $url)
                        @if($page == $ports->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($ports->hasMorePages())
                        <a href="{{ $ports->nextPageUrl() }}"><i class="fa-solid fa-chevron-right"></i></a>
                    @else
                        <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ====== SINGLE ADD MODAL (DARK NAVY) ====== --}}
    <div class="modal fade modal-navy" id="addPortModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-plus me-2" style="color:#4f7ddb;"></i>Tambah Titik Pelabuhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.ports.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelabuhan</label>
                            <input type="text" name="name" class="form-control" placeholder="Misal: Port of Shanghai" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Negara Pemilik</label>
                            <select name="country_id" class="form-select" required>
                                <option value="" disabled selected>Pilih Negara...</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="number" step="any" name="lat" class="form-control" placeholder="-6.111" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="number" step="any" name="lng" class="form-control" placeholder="106.883" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-save"><i class="fa-solid fa-check me-1"></i>Simpan Pelabuhan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ====== SINGLE EDIT MODAL (DYNAMIC, REUSED) ====== --}}
    <div class="modal fade modal-navy" id="editPortModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2" style="color:#4f7ddb;"></i>Edit Pelabuhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPortForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelabuhan</label>
                            <input type="text" name="name" id="editPortName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Negara Pemilik</label>
                            <select name="country_id" id="editPortCountry" class="form-select" required>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="number" step="any" name="lat" id="editPortLat" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="number" step="any" name="lng" id="editPortLng" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-save"><i class="fa-solid fa-check me-1"></i>Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditPort(id, name, countryId, lat, lng) {
            document.getElementById('editPortForm').action = '/admin/ports/' + id;
            document.getElementById('editPortName').value = name;
            document.getElementById('editPortCountry').value = countryId;
            document.getElementById('editPortLat').value = lat;
            document.getElementById('editPortLng').value = lng;
            new bootstrap.Modal(document.getElementById('editPortModal')).show();
        }
    </script>
@endsection