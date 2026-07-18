@extends('layouts.app')

@section('content')
    <style>
        /* ====== ADMIN USERS - DARK NAVY THEME ====== */
        .admin-users { display: flex; flex-direction: column; height: 100%; gap: 1rem; }

        .admin-users .page-header {
            display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;
        }
        .admin-users .page-header .title-group h3 {
            font-size: 1.3rem; font-weight: 800; color: #e2e8f0;
            margin-bottom: 0.1rem; letter-spacing: -0.5px;
        }
        .admin-users .page-header .title-group p {
            font-size: 0.78rem; color: #94a3b8; margin: 0;
        }
        .admin-users .btn-add-user {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff; border: none; padding: 0.55rem 1.2rem; border-radius: 10px;
            font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; gap: 0.45rem;
            transition: all 0.25s ease; cursor: pointer;
        }
        .admin-users .btn-add-user:hover {
            transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,0.35);
        }

        /* Alert */
        .admin-users .alert-navy {
            background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2);
            color: #4ade80; border-radius: 10px; padding: 0.7rem 1rem;
            font-size: 0.78rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;
            flex-shrink: 0;
        }
        .admin-users .alert-danger-navy {
            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);
            color: #f87171; border-radius: 10px; padding: 0.7rem 1rem;
            font-size: 0.78rem; flex-shrink: 0;
        }

        /* Table Card */
        .admin-users .table-card {
            background: #111d35; border-radius: 14px; border: 1px solid #1e3054;
            flex: 1; overflow: hidden; display: flex; flex-direction: column;
        }
        .admin-users .table-card .table-scroll { flex: 1; overflow-y: auto; }
        .admin-users .table-card table { width: 100%; border-collapse: collapse; }
        .admin-users .table-card thead th {
            background: #0d1a30; color: #64748b; font-size: 0.68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px; padding: 0.75rem 1rem;
            border-bottom: 1px solid #1e3054; position: sticky; top: 0; z-index: 5;
        }
        .admin-users .table-card tbody tr {
            border-bottom: 1px solid #1a2744; transition: background 0.2s ease;
        }
        .admin-users .table-card tbody tr:hover { background: rgba(99,102,241,0.06); }
        .admin-users .table-card tbody td {
            padding: 0.65rem 1rem; font-size: 0.8rem; color: #cbd5e1; vertical-align: middle;
        }
        .admin-users .user-name-cell {
            display: flex; align-items: center; gap: 0.7rem;
        }
        .admin-users .user-avatar {
            width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; color: #fff; font-weight: 700;
        }
        .admin-users .user-name-text { font-weight: 600; color: #e2e8f0; }
        .admin-users .role-badge {
            font-size: 0.68rem; font-weight: 700; padding: 0.3rem 0.65rem;
            border-radius: 8px; letter-spacing: 0.3px;
        }
        .admin-users .role-admin {
            background: rgba(99,102,241,0.15); color: #818cf8;
        }
        .admin-users .role-user {
            background: rgba(56,189,248,0.12); color: #38bdf8;
        }

        /* Action Buttons */
        .admin-users .action-btns { display: flex; gap: 0.4rem; justify-content: flex-end; }
        .admin-users .btn-act {
            width: 30px; height: 30px; border-radius: 8px; border: none;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; cursor: pointer; transition: all 0.2s ease;
        }
        .admin-users .btn-edit { background: rgba(79,125,219,0.12); color: #4f7ddb; }
        .admin-users .btn-edit:hover { background: #4f7ddb; color: #fff; }
        .admin-users .btn-del { background: rgba(239,68,68,0.1); color: #f87171; }
        .admin-users .btn-del:hover { background: #ef4444; color: #fff; }

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
            outline: none; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
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
            background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none; color: #fff;
            padding: 0.5rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.8rem;
            cursor: pointer; transition: all 0.2s ease;
        }
        .modal-navy .btn-save:hover { box-shadow: 0 4px 15px rgba(99,102,241,0.35); }
    </style>

    <div class="admin-users" style="background: linear-gradient(180deg, #0d1e3d 0%, #0f2044 100%); margin: -1.25rem -1.5rem; padding: 1.25rem 1.5rem; height: calc(100% + 2.5rem);">

        {{-- Header --}}
        <div class="page-header">
            <div class="title-group">
                <h3><i class="fa-solid fa-users-gear me-2" style="color: #818cf8;"></i>Manajemen Pengguna</h3>
                <p>Kelola hak akses, tambah akun, dan pantau pengguna sistem.</p>
            </div>
            <button type="button" class="btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fa-solid fa-plus"></i> Tambah Pengguna Baru
            </button>
        </div>

        {{-- Alert --}}
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
                            <th>Nama Pengguna</th>
                            <th>Alamat Email</th>
                            <th>Hak Akses (Role)</th>
                            <th>Tanggal Terdaftar</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-name-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="user-name-text">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td style="color: #94a3b8;">{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="role-badge role-admin">Administrator</span>
                                @else
                                    <span class="role-badge role-user">User Biasa</span>
                                @endif
                            </td>
                            <td style="color: #64748b; font-size: 0.75rem;">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y, H:i') }}
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button type="button" class="btn-act btn-edit" title="Edit Akun"
                                        onclick="openEditUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    @if($user->email !== 'admin@gmail.com')
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;"
                                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus akun {{ addslashes($user->name) }} secara permanen?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-act btn-del" title="Hapus Akun">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH USER --}}
    <div class="modal fade modal-navy" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-user-plus me-2" style="color:#818cf8;"></i>Buat Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@perusahaan.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hak Akses (Role)</label>
                            <select name="role" class="form-select" required>
                                <option value="user" selected>User Biasa (Akses Dasbor Saja)</option>
                                <option value="admin">Administrator (Akses Penuh)</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Password Sementara</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter..." required minlength="8">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-save"><i class="fa-solid fa-check me-1"></i>Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT USER (DYNAMIC SINGLE) --}}
    <div class="modal fade modal-navy" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2" style="color:#818cf8;"></i>Edit Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" id="editUserName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" id="editUserEmail" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hak Akses (Role)</label>
                            <select name="role" id="editUserRole" class="form-select" required>
                                <option value="user">User Biasa (Akses Dasbor Saja)</option>
                                <option value="admin">Administrator (Akses Penuh)</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Ganti Password (Opsional)</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti" minlength="8">
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
        function openEditUser(id, name, email, role) {
            document.getElementById('editUserForm').action = '/admin/users/' + id;
            document.getElementById('editUserName').value = name;
            document.getElementById('editUserEmail').value = email;
            document.getElementById('editUserRole').value = role;
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        }
    </script>
@endsection