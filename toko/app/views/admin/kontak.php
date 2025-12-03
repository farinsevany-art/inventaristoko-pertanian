<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';
?>

<div id="layoutSidenav_content">
<main>
<div class="container-fluid px-4">
    <h1 class="mt-4">Daftar Kontak</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data Kontak</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Kontak
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>no</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Pesan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($kontakList)): ?>
                    <?php foreach ($kontakList as $i => $k): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($k['nama']) ?></td>
                            <td><?= htmlspecialchars($k['email']) ?></td>
                            <td><?= htmlspecialchars($k['no_telp']) ?></td>
                            <td><?= nl2br(htmlspecialchars($k['pesan'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">Tidak ada kontak.</td></tr>
                <?php endif; ?>
            </tbody>
            </table>
            </div>
        </div>
    </div>

</div>
</main>
</div>
