{{--
    Partial: _sampul_upload.blade.php
    Props:
      $currentSampul  — path sampul saat ini (string|null), hanya untuk form edit
      $isEdit         — boolean, true jika form edit
--}}
@php
    $isEdit       = $isEdit ?? false;
    $currentSampul = $currentSampul ?? null;
    use Illuminate\Support\Facades\Storage;
    $hasSampul = $isEdit && $currentSampul && Storage::disk('public')->exists($currentSampul);
@endphp

<div class="col-12">
    {{-- ── Label + tombol panduan (?) ──────────────────────────────── --}}
    <div class="d-flex align-items-center gap-2 mb-2">
        <label class="form-label fw-semibold mb-0">Sampul Buku</label>
        <button type="button"
                class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center p-0 border-0"
                style="width:22px;height:22px;background:#e0e7ff;color:#2563eb;font-size:.75rem;font-weight:700;flex-shrink:0"
                data-bs-toggle="modal" data-bs-target="#modalPanduanSampul"
                title="Panduan mengunggah sampul buku">
            ?
        </button>
    </div>

    {{-- ── Area upload + preview ────────────────────────────────────── --}}
    <div class="d-flex gap-3 align-items-start">

        {{-- Preview box --}}
        <div class="rounded border flex-shrink-0 position-relative overflow-hidden"
             id="sampulPreviewWrap"
             style="width:110px;height:145px;background:#f8fafc">
            @if($hasSampul)
                <img id="sampulPreviewImg"
                     src="{{ Storage::disk('public')->url($currentSampul) }}"
                     alt="Sampul" class="w-100 h-100" style="object-fit:cover">
                <span id="sampulPreviewIcon" class="d-none"></span>
            @else
                <img id="sampulPreviewImg" src="" alt=""
                     class="d-none w-100 h-100" style="object-fit:cover">
                <div id="sampulPreviewIcon"
                     class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                    <i class="bi bi-image" style="font-size:2rem"></i>
                    <span style="font-size:.65rem;margin-top:4px">Pratinjau</span>
                </div>
            @endif
        </div>

        {{-- Input + info --}}
        <div class="flex-grow-1">
            {{-- Langkah singkat di atas input --}}
            <div class="rounded-3 p-2 mb-2 small"
                 style="background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af;line-height:1.6">
                <div class="fw-semibold mb-1">
                    <i class="bi bi-info-circle me-1"></i>Cara mengunggah sampul:
                </div>
                <ol class="mb-0 ps-3">
                    <li>Klik <strong>Pilih File</strong> di bawah ini</li>
                    <li>Pilih gambar (JPG / PNG / WEBP, maks. 2MB)</li>
                    <li>Pratinjau muncul otomatis di sebelah kiri</li>
                    <li>Klik <strong>{{ $isEdit ? 'Perbarui' : 'Simpan' }} Buku</strong> untuk menyimpan</li>
                </ol>
            </div>

            {{-- Input file --}}
            <input type="file"
                   name="sampul_buku"
                   id="sampulInput"
                   accept=".jpg,.jpeg,.png,.webp"
                   class="form-control @error('sampul_buku') is-invalid @enderror">

            {{-- Error dari server --}}
            @error('sampul_buku')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            {{-- Error client-side (JS) --}}
            <div id="sampulErrorMsg" class="text-danger small mt-1 d-none"></div>

            {{-- Info format --}}
            <div class="form-text mt-1">
                @if($hasSampul)
                    Upload baru untuk mengganti sampul saat ini.
                @else
                    Format yang didukung: JPG, PNG, WEBP &mdash; Ukuran maksimal 2MB.
                @endif
            </div>

            {{-- Checkbox hapus (hanya edit & ada sampul) --}}
            @if($hasSampul)
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox"
                       name="hapus_sampul" id="hapusSampul" value="1">
                <label class="form-check-label small text-danger" for="hapusSampul">
                    <i class="bi bi-trash me-1"></i>Hapus sampul saat ini
                </label>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ── Modal Panduan Lengkap ─────────────────────────────────────────── --}}
<div class="modal fade" id="modalPanduanSampul" tabindex="-1" aria-labelledby="modalPanduanSampulLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow">
            <div class="modal-header border-0 pb-0"
                 style="background:linear-gradient(135deg,#1e3a5f,#2563eb);border-radius:.75rem .75rem 0 0">
                <h6 class="modal-title text-white fw-semibold" id="modalPanduanSampulLabel">
                    <i class="bi bi-image me-2"></i>Panduan Mengunggah Sampul Buku
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-4">

                {{-- Langkah-langkah --}}
                <div class="d-flex flex-column gap-3">

                    <div class="d-flex gap-3 align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                             style="width:32px;height:32px;background:#2563eb;font-size:.85rem">1</div>
                        <div>
                            <div class="fw-semibold">Klik tombol <em>Pilih File</em></div>
                            <div class="small text-muted">
                                Temukan kolom <strong>Sampul Buku</strong> pada form ini, lalu klik tombol
                                <strong>Pilih File</strong> (atau <em>Choose File</em>) yang muncul di input.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                             style="width:32px;height:32px;background:#2563eb;font-size:.85rem">2</div>
                        <div>
                            <div class="fw-semibold">Pilih gambar dari komputer</div>
                            <div class="small text-muted">
                                Pilih file gambar dengan format yang didukung:
                            </div>
                            <div class="d-flex gap-2 mt-1 flex-wrap">
                                <span class="badge rounded-pill" style="background:#dbeafe;color:#1d4ed8">JPG / JPEG</span>
                                <span class="badge rounded-pill" style="background:#dcfce7;color:#15803d">PNG</span>
                                <span class="badge rounded-pill" style="background:#fef9c3;color:#854d0e">WEBP</span>
                            </div>
                            <div class="small text-muted mt-1">
                                Ukuran file <strong>maksimal 2MB</strong>.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                             style="width:32px;height:32px;background:#2563eb;font-size:.85rem">3</div>
                        <div>
                            <div class="fw-semibold">Pratinjau muncul otomatis</div>
                            <div class="small text-muted">
                                Setelah file dipilih, gambar akan langsung tampil di kotak pratinjau
                                di sebelah kiri input. Pastikan gambar sudah sesuai sebelum menyimpan.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 align-items-start">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                             style="width:32px;height:32px;background:#2563eb;font-size:.85rem">4</div>
                        <div>
                            <div class="fw-semibold">
                                Klik <em>{{ $isEdit ? 'Perbarui' : 'Simpan' }} Buku</em>
                            </div>
                            <div class="small text-muted">
                                Klik tombol <strong>{{ $isEdit ? 'Perbarui' : 'Simpan' }} Buku</strong>
                                di bagian bawah form. Sampul akan tersimpan bersama data buku.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pesan error yang mungkin muncul --}}
                <hr class="my-3">
                <div class="small fw-semibold text-muted mb-2">
                    <i class="bi bi-exclamation-triangle me-1 text-warning"></i>Pesan error yang mungkin muncul:
                </div>
                <div class="d-flex flex-column gap-2">
                    <div class="rounded-3 p-2" style="background:#fee2e2;border:1px solid #fca5a5">
                        <div class="small fw-semibold text-danger">Format file salah</div>
                        <div class="small text-danger">"Hanya file JPG, PNG, WEBP yang diperbolehkan"</div>
                    </div>
                    <div class="rounded-3 p-2" style="background:#fee2e2;border:1px solid #fca5a5">
                        <div class="small fw-semibold text-danger">File terlalu besar</div>
                        <div class="small text-danger">"Ukuran file maksimal 2MB"</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-primary btn-sm px-4" data-bs-dismiss="modal">
                    <i class="bi bi-check-lg me-1"></i>Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
(function () {
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
    const MAX_SIZE_MB   = 2;
    const MAX_SIZE_BYTE = MAX_SIZE_MB * 1024 * 1024;

    const input    = document.getElementById('sampulInput');
    const errMsg   = document.getElementById('sampulErrorMsg');
    const previewImg  = document.getElementById('sampulPreviewImg');
    const previewIcon = document.getElementById('sampulPreviewIcon');
    const hapusCheck  = document.getElementById('hapusSampul');

    function showError(msg) {
        errMsg.textContent = msg;
        errMsg.classList.remove('d-none');
        input.classList.add('is-invalid');
    }

    function clearError() {
        errMsg.textContent = '';
        errMsg.classList.add('d-none');
        input.classList.remove('is-invalid');
    }

    function showPreview(src) {
        previewImg.src = src;
        previewImg.classList.remove('d-none');
        if (previewIcon) previewIcon.classList.add('d-none');
    }

    function clearPreview() {
        previewImg.src = '';
        previewImg.classList.add('d-none');
        if (previewIcon) previewIcon.classList.remove('d-none');
    }

    if (input) {
        input.addEventListener('change', function () {
            clearError();
            const file = this.files[0];

            if (!file) {
                clearPreview();
                return;
            }

            // Validasi format
            if (!ALLOWED_TYPES.includes(file.type)) {
                showError('Hanya file JPG, PNG, WEBP yang diperbolehkan.');
                this.value = '';
                clearPreview();
                return;
            }

            // Validasi ukuran
            if (file.size > MAX_SIZE_BYTE) {
                showError('Ukuran file maksimal 2MB. File yang dipilih: ' +
                    (file.size / 1024 / 1024).toFixed(2) + 'MB.');
                this.value = '';
                clearPreview();
                return;
            }

            // Tampilkan pratinjau
            const reader = new FileReader();
            reader.onload = function (ev) { showPreview(ev.target.result); };
            reader.readAsDataURL(file);
        });
    }

    // Checkbox hapus sampul
    if (hapusCheck) {
        hapusCheck.addEventListener('change', function () {
            if (this.checked) {
                clearPreview();
                // Reset input juga agar tidak upload baru sekaligus hapus
                if (input) { input.value = ''; clearError(); }
            } else {
                // Kembalikan preview sampul lama jika ada
                const lama = previewImg.dataset.lama;
                if (lama) showPreview(lama);
            }
        });

        // Simpan URL sampul lama ke data attribute untuk restore
        if (previewImg && previewImg.src && !previewImg.classList.contains('d-none')) {
            previewImg.dataset.lama = previewImg.src;
        }
    }

    // Validasi saat submit — cegah submit jika ada error client-side
    const form = input ? input.closest('form') : null;
    if (form) {
        form.addEventListener('submit', function (e) {
            if (input.files.length > 0) {
                const file = input.files[0];
                if (!ALLOWED_TYPES.includes(file.type)) {
                    e.preventDefault();
                    showError('Hanya file JPG, PNG, WEBP yang diperbolehkan.');
                    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }
                if (file.size > MAX_SIZE_BYTE) {
                    e.preventDefault();
                    showError('Ukuran file maksimal 2MB.');
                    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }
})();
</script>
@endpush
@endonce
