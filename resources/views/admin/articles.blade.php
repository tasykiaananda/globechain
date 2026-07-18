@extends('layouts.app')

@section('content')
    <style>
        /* ====== ADMIN ARTICLES - DARK NAVY THEME ====== */
        .admin-articles { display: flex; flex-direction: column; height: 100%; gap: 1rem; }

        .admin-articles .page-header {
            display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;
        }
        .admin-articles .page-header .title-group h3 {
            font-size: 1.3rem; font-weight: 800; color: #e2e8f0;
            margin-bottom: 0.1rem; letter-spacing: -0.5px;
        }
        .admin-articles .page-header .title-group p {
            font-size: 0.78rem; color: #94a3b8; margin: 0;
        }
        .admin-articles .btn-add-article {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: #0f172a; border: none; padding: 0.55rem 1.2rem; border-radius: 10px;
            font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; gap: 0.45rem;
            transition: all 0.25s ease; cursor: pointer;
        }
        .admin-articles .btn-add-article:hover {
            transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245,158,11,0.35);
        }

        /* Alert */
        .admin-articles .alert-navy {
            background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2);
            color: #4ade80; border-radius: 10px; padding: 0.7rem 1rem;
            font-size: 0.78rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;
            flex-shrink: 0;
        }

        /* Table Card */
        .admin-articles .table-card {
            background: #111d35; border-radius: 14px; border: 1px solid #1e3054;
            flex: 1; overflow: hidden; display: flex; flex-direction: column;
        }
        .admin-articles .table-card .table-scroll { flex: 1; overflow-y: auto; }
        .admin-articles .table-card table { width: 100%; border-collapse: collapse; }
        .admin-articles .table-card thead th {
            background: #0d1a30; color: #64748b; font-size: 0.68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px; padding: 0.75rem 1rem;
            border-bottom: 1px solid #1e3054; position: sticky; top: 0; z-index: 5;
        }
        .admin-articles .table-card tbody tr {
            border-bottom: 1px solid #1a2744; transition: background 0.2s ease;
        }
        .admin-articles .table-card tbody tr:hover { background: rgba(245,158,11,0.05); }
        .admin-articles .table-card tbody td {
            padding: 0.65rem 1rem; font-size: 0.8rem; color: #cbd5e1; vertical-align: middle;
        }
        .admin-articles .article-cell {
            display: flex; align-items: center; gap: 0.7rem;
        }
        .admin-articles .article-icon {
            width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
            background: rgba(245,158,11,0.12); color: #fbbf24;
            display: flex; align-items: center; justify-content: center; font-size: 0.85rem;
        }
        .admin-articles .article-title-text { font-weight: 600; color: #e2e8f0; display: block; }
        .admin-articles .article-excerpt {
            font-size: 0.7rem; color: #64748b; font-weight: 400;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 350px;
        }

        /* Action Buttons */
        .admin-articles .action-btns { display: flex; gap: 0.4rem; justify-content: flex-end; }
        .admin-articles .btn-act {
            width: 30px; height: 30px; border-radius: 8px; border: none;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; cursor: pointer; transition: all 0.2s ease;
        }
        .admin-articles .btn-edit { background: rgba(79,125,219,0.12); color: #4f7ddb; }
        .admin-articles .btn-edit:hover { background: #4f7ddb; color: #fff; }
        .admin-articles .btn-del { background: rgba(239,68,68,0.1); color: #f87171; }
        .admin-articles .btn-del:hover { background: #ef4444; color: #fff; }

        /* Empty State */
        .admin-articles .empty-state {
            text-align: center; padding: 3rem; color: #475569;
        }
        .admin-articles .empty-state i { font-size: 2.5rem; color: #1e3054; margin-bottom: 0.8rem; display: block; }
        .admin-articles .empty-state p { font-size: 0.85rem; color: #64748b; }

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
            outline: none; border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.15);
            background: #1e2f4f;
        }
        .modal-navy .modal-footer { border-top: 1px solid #1e3054; padding: 1rem 1.5rem; }
        .modal-navy .btn-cancel {
            background: transparent; border: 1.5px solid #2a3f66; color: #94a3b8;
            padding: 0.5rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: 0.8rem;
            cursor: pointer; transition: all 0.2s ease;
        }
        .modal-navy .btn-cancel:hover { border-color: #64748b; color: #e2e8f0; }
        .modal-navy .btn-save {
            background: linear-gradient(135deg, #f59e0b, #fbbf24); border: none; color: #0f172a;
            padding: 0.5rem 1.5rem; border-radius: 10px; font-weight: 700; font-size: 0.8rem;
            cursor: pointer; transition: all 0.2s ease;
        }
        .modal-navy .btn-save:hover { box-shadow: 0 4px 15px rgba(245,158,11,0.35); }
    </style>

    <div class="admin-articles" style="background: linear-gradient(180deg, #0d1e3d 0%, #0f2044 100%); margin: -1.25rem -1.5rem; padding: 1.25rem 1.5rem; height: calc(100% + 2.5rem);">

        {{-- Header --}}
        <div class="page-header">
            <div class="title-group">
                <h3><i class="fa-solid fa-newspaper me-2" style="color: #fbbf24;"></i>Artikel Analisis</h3>
                <p>Terbitkan laporan intelijen risiko rantai pasok dan info logistik global.</p>
            </div>
            <button type="button" class="btn-add-article" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                <i class="fa-solid fa-pen-nib"></i> Tulis Artikel Baru
            </button>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert-navy">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="table-card">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 42%;">Judul Artikel</th>
                            <th>Penulis (Author)</th>
                            <th>Tanggal Terbit</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>
                                <div class="article-cell">
                                    <div class="article-icon"><i class="fa-solid fa-newspaper"></i></div>
                                    <div>
                                        <span class="article-title-text">{{ $article->title }}</span>
                                        <span class="article-excerpt">{{ Str::limit($article->content, 60) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td style="color: #94a3b8;">
                                <i class="fa-solid fa-user-pen me-1" style="color: #475569;"></i> {{ $article->author_name }}
                            </td>
                            <td style="color: #64748b; font-size: 0.75rem;">
                                {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y, H:i') }}
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button type="button" class="btn-act btn-edit" title="Edit Artikel"
                                        onclick="openEditArticle({{ $article->id }}, '{{ addslashes($article->title) }}', `{{ addslashes($article->content) }}`)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.articles.delete', $article->id) }}" method="POST" style="display:inline;"
                                        onsubmit="return confirm('Hapus artikel ini secara permanen?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-act btn-del" title="Hapus Artikel">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fa-solid fa-folder-open"></i>
                                    <p>Belum ada artikel analisis yang diterbitkan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH ARTIKEL --}}
    <div class="modal fade modal-navy" id="addArticleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-pen-nib me-2" style="color:#fbbf24;"></i>Tulis Artikel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.articles.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Analisis</label>
                            <input type="text" name="title" class="form-control" placeholder="Misal: Dampak Badai di Selat Malaka terhadap Rantai Pasok" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Artikel / Laporan</label>
                            <textarea name="content" class="form-control" rows="8" placeholder="Tulis rincian analisis di sini..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-save"><i class="fa-solid fa-check me-1"></i>Terbitkan Artikel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT ARTIKEL (DYNAMIC SINGLE) --}}
    <div class="modal fade modal-navy" id="editArticleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2" style="color:#fbbf24;"></i>Edit Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editArticleForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Analisis</label>
                            <input type="text" name="title" id="editArticleTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Artikel / Laporan</label>
                            <textarea name="content" id="editArticleContent" class="form-control" rows="8" required></textarea>
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
        function openEditArticle(id, title, content) {
            document.getElementById('editArticleForm').action = '/admin/articles/' + id;
            document.getElementById('editArticleTitle').value = title;
            document.getElementById('editArticleContent').value = content;
            new bootstrap.Modal(document.getElementById('editArticleModal')).show();
        }
    </script>
@endsection