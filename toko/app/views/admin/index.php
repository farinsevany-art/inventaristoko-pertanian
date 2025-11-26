<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';

// nilai maksimal stok gudang & etalase
$maxGudangValue = isset($maxGudang[0]['total_stok_gudang']) ? $maxGudang[0]['total_stok_gudang'] : 1;
$maxEtalaseValue = isset($maxEtalase[0]['total_stok_eta']) ? $maxEtalase[0]['total_stok_eta'] : 1;
$barangList = [];

// stok gudang
foreach ($stokGudangAll as $item) {
    $nama = $item['nama_barang'] ?? "Tidak diketahui";
    if (!isset($barangList[$nama])) {
        $barangList[$nama] = ['gudang' => 0, 'etalase' => 0];
    }
    $barangList[$nama]['gudang'] += $item['total_stok_gudang'];
}

// stok etalase
foreach ($stokEtalaseAll as $item) {
    $nama = $item['nama_barang'] ?? "Tidak diketahui";
    if (!isset($barangList[$nama])) {
        $barangList[$nama] = ['gudang' => 0, 'etalase' => 0];
    }
    $barangList[$nama]['etalase'] += $item['total_stok_eta'];
}
?>

<div id="layoutSidenav_content">
<main>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Stok</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Ringkasan Stok -->
    <div class="row">

        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Total Stok Gudang</h5>
                    <h2><?= $totalGudang ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="?url=stokGudang/index">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h5>Total Stok Etalase</h5>
                    <h2><?= $totalEtalase ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="?url=stokEtalase/index">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h5>Stok Menipis</h5>
                    <h2><?= count($lowGudang) + count($lowEtalase) ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="?url=stok/low">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h5>Stok Habis</h5>
                    <h2><?= count($zeroGudang) + count($zeroEtalase) ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="?url=stok/habis">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

<!-- GRAFIK -->
<div class="card mb-4 shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Grafik Stok Barang</h5>
    </div>

    <!-- Wrapper responsif dengan scroll -->
    <div class="chart-scroll-wrapper">
        <div class="chart-inner">
            <div class="chart-container">
                <canvas id="stokChart"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
/* scroll horizontal */
.chart-scroll-wrapper {
    overflow-x: auto;
    overflow-y: hidden;
    width: 100%;
    padding-bottom: 8px;
}

/* container fleksibel */
.chart-inner {
    min-width: 100%;
}

/* ukuran grafik responsif */
.chart-container {
    position: relative;
    width: 100%;
    min-height: 360px;
}

@media (max-width: 1000px) {
    .chart-container {
        min-height: 450px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('stokChart').getContext('2d');

const labels = <?= json_encode(array_keys($barangList)) ?>;
const gudang = <?= json_encode(array_column($barangList, 'gudang')) ?>;
const etalase = <?= json_encode(array_column($barangList, 'etalase')) ?>;

// Atur lebar otomatis berdasarkan jumlah barang
const minWidth = labels.length * 90;
document.querySelector(".chart-inner").style.width = Math.max(window.innerWidth, minWidth) + "px";

new Chart(ctx, {
    type: 'bar',
    data: {
        labels,
        datasets: [
            {
                label: "Stok Gudang",
                data: gudang,
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            },
            {
                label: "Stok Etalase",
                data: etalase,
                backgroundColor: 'rgba(255, 159, 64, 0.7)'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { 
                beginAtZero: true,
                max: 180
            }
        }
    }
});
</script>

</div>
</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
