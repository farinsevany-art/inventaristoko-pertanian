<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tempatkan Stok ke Etalase</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="?url=stokgudang/index">Stok Gudang</a></li>
                <li class="breadcrumb-item active">Tempatkan ke Etalase</li>
            </ol>

            <?php if (empty($stok)) : ?>
                <div class="alert alert-danger">Stok tidak ditemukan.</div>
            <?php else : ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-box-open me-1"></i>
                        Form Penempatan Stok ke Etalase
                    </div>
                    <div class="card-body">
                        <!-- Info Barang yang akan dipindahkan -->
                        <div class="mb-3 p-3 bg-light rounded">
                            <h6>Informasi Barang:</h6>
                            <p><strong>Nama:</strong> <?= htmlspecialchars($stok['nama_barang']) ?></p>
                            <p><strong>Jenis:</strong> <?= htmlspecialchars($stok['jenis_barang']) ?></p>
                            <p><strong>Kadaluarsa:</strong> <?= htmlspecialchars($stok['kadaluarsa_barang']) ?></p>
                            <p><strong>Stok Tersedia:</strong> <?= htmlspecialchars($stok['total_stok_gudang']) ?></p>
                        </div>

                        <form method="post" action="?url=stokgudang/placeStore">
                            <input type="hidden" name="id_stok_gudang" value="<?= htmlspecialchars($stok['id_stok_gudang']) ?>">

                            <div class="mb-3">
                                <label class="form-label">Pilih Etalase</label>
                                <?php if (empty($etalases)) : ?>
                                    <div class="alert alert-warning">Tidak ada etalase yang cocok untuk barang ini. Sistem akan membuat etalase baru.</div>
                                    <input type="hidden" name="buat_etalase_baru" value="1" id="buat_etalase_baru">
                                <?php else : ?>
                                    <!-- removed: 'Filter Rak' dropdown to simplify placement UI -->

                                    <select name="id_stok_etalase" class="form-select" id="id_stok_etalase">
                                        <option value="">-- Pilih Etalase (atau kosong untuk buat baru) --</option>
                                        <?php foreach ($etalases as $e) : ?>
                                            <option value="<?= htmlspecialchars($e['id_stok_etalase']) ?>" data-rak="<?= htmlspecialchars($e['rak'] ?? '') ?>">
                                                <?= htmlspecialchars(
                                                    $e['id_stok_etalase'] . ' - ' . 
                                                    ($e['nama_barang'] ?? 'Etalase') . ' | ' . 
                                                    ($e['jenis_barang'] ?? '') . ' | ' . 
                                                    'Rak: ' . ($e['rak'] ?? '-') . ' | ' .
                                                    'Stok: ' . $e['total_stok_eta']
                                                ) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">
                                        Pilih etalase yang ada untuk menggunakan rak yang sudah tersimpan.
                                        Biarkan pilihan di atas kosong untuk <strong>membuat etalase baru</strong> dan masukkan rak di bawah.
                                        <input type="hidden" name="buat_etalase_baru" value="0" id="buat_etalase_baru">
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <div class="mb-3" id="rak_choice_group">
                                <label class="form-label">Rak (pilih dari etalase yang ada atau masukkan baru)</label>
                                <div class="d-flex gap-2">
                                    <select class="form-select" id="rak_select" aria-label="Pilih rak yang ada">
                                        <option value="">-- Pilih rak dari stok_etalase (opsional) --</option>
                                        <?php if (!empty($rak_options)) : ?>
                                            <?php foreach ($rak_options as $ro) : ?>
                                                <option value="<?= htmlspecialchars($ro) ?>"><?= htmlspecialchars($ro) ?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                                <option value="__other__">-- Masukkan rak baru --</option>
                                            </select>
                                            
                                            <input class="form-control" name="rak" id="rak_input" type="text" placeholder="Masukkan rak, mis. R1-A" style="display:none;" />
                                        </div>
                                        <div class="form-text" id="rak_help_text" style="display:none;">Jika Anda memilih rak yang ada, itu akan digunakan. Jika memilih "Masukkan rak baru", isi field sebelahnya.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah yang Dipindah</label>
                                        <input type="number" name="stok_gudang_keluar" class="form-control"
                                               min="1" max="<?= htmlspecialchars($stok['total_stok_gudang']) ?>" value="1" required>
                                        <small class="form-text text-muted">Maksimal: <?= htmlspecialchars($stok['total_stok_gudang']) ?> unit</small>
                                    </div>
                                    
                            <input type="hidden" name="tgl_penempatan" value="<?= date('Y-m-d') ?>">

                            <button class="btn btn-primary">Simpan Penempatan</button>
                            <a class="btn btn-secondary" href="?url=stokgudang/index">Batal</a>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Your Website 2023</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= $base_url ?>admin/js/scripts.js"></script>

<script>
// JavaScript to toggle buat_etalase_baru based on dropdown selection
document.addEventListener('DOMContentLoaded', function() {
    const etalaseSelect = document.getElementById('id_stok_etalase');
    const buatEtalaseInput = document.getElementById('buat_etalase_baru');

    if (etalaseSelect && buatEtalaseInput) {
        etalaseSelect.addEventListener('change', function() {
            if (etalaseSelect.value === '') {
                // Blank selection, create new etalase
                buatEtalaseInput.value = '1';
                etalaseSelect.removeAttribute('required');
            } else {
                // Existing etalase selected
                buatEtalaseInput.value = '0';
                etalaseSelect.setAttribute('required', 'required');
            }
        });
    }
});
</script>
<script>
// Sync rak when selecting an etalase: if etalase has rak, show it and make readonly; if not, allow editing.
document.addEventListener('DOMContentLoaded', function() {
    const etalaseSelect = document.getElementById('id_stok_etalase');
    const rakSelect = document.getElementById('rak_select');
    const rakInput = document.getElementById('rak_input');
    const buatEtalaseInput = document.getElementById('buat_etalase_baru');

    function applyRakToFields(rakValue, readonly) {
        if (rakSelect) {
            // try to select the rak option if exists
            let found = false;
            for (let i = 0; i < rakSelect.options.length; i++) {
                const opt = rakSelect.options[i];
                if (opt.value === rakValue) { opt.selected = true; found = true; break; }
            }
            if (!found && rakValue) {
                // add an option for this rak so it's visible
                const newOpt = document.createElement('option');
                newOpt.value = rakValue;
                newOpt.text = rakValue;
                rakSelect.add(newOpt);
                newOpt.selected = true;
            }
            rakSelect.disabled = !!readonly;
        }

        if (rakInput) {
            rakInput.value = rakValue || '';
            rakInput.readOnly = !!readonly;
            // show the text input only when user explicitly chose to enter a new rak
            const showInput = (rakSelect && rakSelect.value === '__other__');
            rakInput.style.display = showInput ? 'block' : 'none';
        }
        // helper text visibility: only show when user is entering a new rak
        const rakHelp = document.getElementById('rak_help_text');
        if (rakHelp) {
            // show helper when input is editable and empty or when user explicitly chose 'other'
            const showing = (!readonly && (rakInput && (rakInput.value === '' || (rakSelect && rakSelect.value === '__other__'))));
            rakHelp.style.display = showing ? 'block' : 'none';
        }
    }

    function syncRakState() {
        if (!etalaseSelect) return;
        const sel = etalaseSelect.selectedOptions[0];
        const rakFromEta = sel ? (sel.dataset.rak || '') : '';

        if (etalaseSelect.value === '') {
            // Creating new etalase: allow selection or custom input
            if (buatEtalaseInput) buatEtalaseInput.value = '1';
            if (rakSelect) {
                rakSelect.disabled = false;
                // keep current rakSelect selection
            }
            if (rakSelect && rakSelect.value && rakSelect.value !== '__other__') {
                // use selected rak
                applyRakToFields(rakSelect.value, false);
            } else {
                // show input editable
                applyRakToFields('', false);
            }
        } else {
            // Existing etalase selected
            if (buatEtalaseInput) buatEtalaseInput.value = '0';
            if (rakFromEta) {
                // force rak to etalase's rak and make readonly
                applyRakToFields(rakFromEta, true);
            } else {
                // no rak in etalase: allow editing/selecting
                applyRakToFields('', false);
            }
        }
    }

    if (etalaseSelect) etalaseSelect.addEventListener('change', syncRakState);
    if (rakSelect) rakSelect.addEventListener('change', function() {
        if (rakSelect.value === '__other__') {
            rakInput.style.display = 'block';
            rakInput.readOnly = false;
            rakInput.value = '';
            rakSelect.disabled = false;
            const rakHelp = document.getElementById('rak_help_text'); if (rakHelp) rakHelp.style.display = 'block';
        } else {
            // a specific rak chosen: set input and keep it editable only if creating new
            const creating = (buatEtalaseInput && buatEtalaseInput.value === '1') || (etalaseSelect && etalaseSelect.value === '');
            rakInput.value = rakSelect.value === '__other__' ? '' : rakSelect.value;
            // when a specific rak is chosen, do NOT show the free-text input (only show when '__other__')
            rakInput.readOnly = true;
            rakInput.style.display = 'none';
            const rakHelp = document.getElementById('rak_help_text'); if (rakHelp) rakHelp.style.display = 'none';
        }
    });

    // initial sync
    syncRakState();
});
</script>
<script>
// removed client-side rak filter: keeping rak selection inputs for placement
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rakSelect = document.getElementById('rak_select');
    const rakInput = document.getElementById('rak_input');
    const etalaseSelect = document.getElementById('id_stok_etalase');
    const buatEtalaseInput = document.getElementById('buat_etalase_baru');

    function updateRakInputVisibility() {
        if (!rakSelect || !rakInput) return;
        if (rakSelect.value === '__other__') {
            rakInput.style.display = 'block';
            rakInput.value = '';
            const rakHelp = document.getElementById('rak_help_text'); if (rakHelp) rakHelp.style.display = 'block';
        } else if (rakSelect.value === '') {
            // no selection: show input only if creating new etalase
            const creating = (buatEtalaseInput && buatEtalaseInput.value === '1') || (etalaseSelect && etalaseSelect.value === '');
            // do not show free-text input unless user chooses '__other__'
            rakInput.style.display = 'none';
            if (!creating) rakInput.value = '';
            const rakHelp = document.getElementById('rak_help_text'); if (rakHelp) rakHelp.style.display = (creating ? 'block' : 'none');
        } else {
            // specific existing rak selected -> keep free-text hidden
            rakInput.style.display = 'none';
            rakInput.value = rakSelect.value;
            const rakHelp = document.getElementById('rak_help_text'); if (rakHelp) rakHelp.style.display = 'none';
        }
    }

    if (rakSelect) {
        rakSelect.addEventListener('change', updateRakInputVisibility);
    }

    // also update when etalase selection changes (so creating new etalase shows input)
    if (etalaseSelect) {
        etalaseSelect.addEventListener('change', updateRakInputVisibility);
    }

    // initial
    updateRakInputVisibility();
});
</script>
</body>
</html>
