<div class="modal fade" id="countryDetailModal" tabindex="-1" aria-labelledby="countryDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom-0 bg-light" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title fw-bold text-dark" id="countryDetailModalLabel">
                    <i class="fa-solid fa-book-atlas text-matcha me-2"></i> Detail Ekstensif Negara
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-matcha border-bottom pb-2 mb-3"><i class="fa-solid fa-map-location-dot me-2"></i> Geografi & Wilayah</h6>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted w-50">Nama Resmi</td>
                                    <td class="fw-bold text-end">{{ $country['names']['official'] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Benua (Region)</td>
                                    <td class="fw-bold text-end">{{ $country['region'] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Sub-Region</td>
                                    <td class="fw-bold text-end">{{ $country['subregion'] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Garis Lintang (Lat)</td>
                                    <td class="fw-bold text-end">{{ isset($country['coordinates']['latitude']) ? $country['coordinates']['latitude'] : '--' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Garis Bujur (Lng)</td>
                                    <td class="fw-bold text-end">{{ isset($country['coordinates']['longitude']) ? $country['coordinates']['longitude'] : '--' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-matcha border-bottom pb-2 mb-3"><i class="fa-solid fa-circle-info me-2"></i> Informasi Umum</h6>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted w-50">Mata Uang Lengkap</td>
                                    <td class="fw-bold text-end">{{ $country['currencies'][0]['name'] ?? '--' }} ({{ $country['currencies'][0]['code'] ?? '' }})</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kode Telepon (Prefix)</td>
                                    <td class="fw-bold text-end">{{ $country['codes']['calling_code'] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Domain Internet (TLD)</td>
                                    <td class="fw-bold text-end">{{ isset($country['tld'][0]) ? $country['tld'][0] : '--' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Anggota ASEAN</td>
                                    <td class="fw-bold text-end">
                                        @if(isset($country['memberships']['asean']) && $country['memberships']['asean'])
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Bukan</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Anggota G20</td>
                                    <td class="fw-bold text-end">
                                        @if(isset($country['memberships']['g20']) && $country['memberships']['g20'])
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Bukan</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>