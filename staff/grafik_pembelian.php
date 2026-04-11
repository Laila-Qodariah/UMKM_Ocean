<?php
$query = "
    SELECT 
        DATE_FORMAT(tanggal, '%Y-%m') as bulan,
        SUM(total_item) as total
    FROM produk_masuk
    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
    ORDER BY bulan ASC
";

$result = mysqli_query($conn, $query);

$bulan = [];
$total = [];

while ($row = mysqli_fetch_assoc($result)) {
    $bulan[] = date('M Y', strtotime($row['bulan'] . '-01'));
    $total[] = (int)$row['total'];
}
?>

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="section-title mb-1">Grafik Pembelian Bulanan</h3>
                    <p class="text-muted mb-0">Visualisasi jumlah produk masuk setiap bulan</p>
                </div>
                <a href="index.php?menu=laporan_pembelian" class="btn btn-secondary">
                    ← Kembali
                </a>
            </div>

            <!-- CARD -->
            <div class="card border-0 shadow-sm" style="border-radius:20px;">
                <div class="card-body">
                    <div style="height: 380px;">
                        <canvas id="grafikPembelian"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('grafikPembelian');

new Chart(ctx, {
    type: 'bar', // 🔥 ini yang diubah
    data: {
        labels: <?= json_encode($bulan); ?>,
        datasets: [{
            label: 'Total Produk Masuk',
            data: <?= json_encode($total); ?>,
            borderWidth: 1,
            borderRadius: 8,
            backgroundColor: 'rgba(0, 150, 199, 0.7)',
            borderColor: '#0096c7'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                display: true
            }
        },

        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>