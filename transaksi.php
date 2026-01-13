<?php 
include 'cek_sesi.php'; 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Pintar - Barcode System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Inter', sans-serif; }
        .card { border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .no-jurnal { font-family: 'Courier New', monospace; font-weight: bold; color: #0d6efd; }
        .table-item-tambahan { background-color: #f0f9ff; }
        .text-price { font-family: 'Consolas', monospace; }
        .input-barcode-focus:focus { border-color: #198754; box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25); }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
        <div>
            <h4 class="fw-bold mb-0 text-dark"><i class="fas fa-cash-register me-2 text-primary"></i>Dashboard Kasir</h4>
            <small class="text-muted">Kelola antrean katalog dan transaksi barcode langsung</small>
        </div>
        <button class="btn btn-success fw-bold px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPesananBaru">
            <i class="fas fa-barcode me-2"></i>TRANSAKSI BARU (SCAN)
        </button>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card h-100">
                <div class="card-header bg-warning py-3 text-dark fw-bold">
                    <i class="fas fa-user-clock me-2"></i>Antrean Katalog
                </div>
                <div class="list-group list-group-flush">
                    <?php
                    $q_antrean = mysqli_query($koneksi, "SELECT nama_pelanggan, COUNT(*) as total_item FROM antrean_pesanan GROUP BY nama_pelanggan");
                    if(mysqli_num_rows($q_antrean) > 0) {
                        while($a = mysqli_fetch_assoc($q_antrean)) {
                            $safe_id = str_replace(['=', '+', '/'], '', base64_encode($a['nama_pelanggan']));
                    ?>
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold"><?php echo $a['nama_pelanggan']; ?></span>
                                <span class="badge bg-primary rounded-pill"><?php echo $a['total_item']; ?> Item</span>
                            </div>
                            <button class="btn btn-outline-primary btn-sm w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#modalCek<?php echo $safe_id; ?>">
                                Buka Pesanan <i class="fas fa-external-link-alt ms-1"></i>
                            </button>
                        </div>
                    <?php } } else { echo "<div class='p-5 text-center text-muted small'>Tidak ada antrean dari katalog</div>"; } ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card h-100">
                <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Histori Penjualan Terbaru</h6>
                    <a href="main_menu.php" class="btn btn-sm btn-light fw-bold">Menu Utama</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No. Jurnal</th>
                                <th>Waktu</th>
                                <th>Pelanggan</th>
                                <th class="text-end">Total Bayar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $jurnal = mysqli_query($koneksi, "SELECT * FROM penjualan_header ORDER BY tgl_transaksi DESC LIMIT 10");
                            while($j = mysqli_fetch_assoc($jurnal)) {
                                $id_j_modal = "DETAIL".substr($j['no_jurnal'], -6);
                            ?>
                            <tr>
                                <td class="ps-4 no-jurnal"><?php echo $j['no_jurnal']; ?></td>
                                <td class="small"><?php echo date('H:i', strtotime($j['tgl_transaksi'])); ?></td>
                                <td><?php echo $j['nama_pelanggan']; ?></td>
                                <td class="text-end fw-bold text-success text-price">Rp <?php echo number_format($j['total_bayar'], 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#<?php echo $id_j_modal; ?>">Detail</button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPesananBaru" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <form action="proses_transaksi.php?aksi=update_dan_proses" method="POST">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Input Pesanan Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 px-2">
                        <label class="form-label small fw-bold">NAMA PELANGGAN</label>
                        <input type="text" name="nama_pelanggan" class="form-control form-control-lg" placeholder="Input Nama..." required>
                    </div>
                    
                    <div class="p-3 bg-light rounded border mx-2 mb-3">
                        <div class="row g-2">
                            <div class="col-7">
                                <label class="small fw-bold text-success"><i class="fas fa-barcode me-1"></i>SCAN BARCODE / KETIK KODE</label>
                                <input type="text" id="inputBarcode" class="form-control input-barcode-focus" placeholder="Scan barang..." autofocus>
                                <div id="barcodeFeedback" class="small mt-1 fw-bold"></div>
                            </div>
                            <div class="col-3">
                                <label class="small fw-bold">QTY</label>
                                <input type="number" id="qtyBarcode" class="form-control" value="1" min="1">
                            </div>
                            <div class="col-2 d-flex align-items-end">
                                <button type="button" class="btn btn-dark w-100 fw-bold" onclick="cariBarangBarcode()">OK</button>
                            </div>
                        </div>
                    </div>

                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Item</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center" width="100">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="listPesananBaru"></tbody>
                        <tfoot class="table-light fw-bold fs-5">
                            <tr>
                                <td colspan="3" class="text-end py-3">TOTAL BAYAR</td>
                                <td class="text-end text-success text-price" id="totalBayarBaru">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success px-5 fw-bold py-2 shadow-sm">SIMPAN & PROSES</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
mysqli_data_seek($q_antrean, 0);
while($a = mysqli_fetch_assoc($q_antrean)) {
    $nama_p = $a['nama_pelanggan'];
    $safe_id = str_replace(['=', '+', '/'], '', base64_encode($nama_p));
?>
<div class="modal fade" id="modalCek<?php echo $safe_id; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <form action="proses_transaksi.php?aksi=update_dan_proses" method="POST">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Order: <?php echo $nama_p; ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <input type="hidden" name="nama_pelanggan" value="<?php echo $nama_p; ?>">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Item</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center" width="90">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center">Batal</th>
                            </tr>
                        </thead>
                        <tbody id="listAntrean<?php echo $safe_id; ?>">
                            <?php
                            $total_ant = 0;
                            $it_q = mysqli_query($koneksi, "SELECT a.*, b.item_name, b.harga FROM antrean_pesanan a JOIN daftar_barang b ON a.item_code = b.item_code WHERE a.nama_pelanggan = '$nama_p'");
                            while($it = mysqli_fetch_assoc($it_q)) {
                                $sub = $it['harga'] * 1; $total_ant += $sub;
                            ?>
                                <tr class="item-row">
                                    <td class="ps-3"><b><?php echo $it['item_name']; ?></b><br><small><?php echo $it['item_code']; ?></small>
                                        <input type="hidden" name="item_code[]" value="<?php echo $it['item_code']; ?>"></td>
                                    <td class="text-end">Rp <?php echo number_format($it['harga'], 0, ',', '.'); ?>
                                        <input type="hidden" class="harga-satuan" value="<?php echo $it['harga']; ?>"></td>
                                    <td><input type="number" name="qty[]" class="form-control form-control-sm text-center input-qty" value="1" onchange="hitungTotalGeneral(this)"></td>
                                    <td class="text-end fw-bold subtotal-text text-price">Rp <?php echo number_format($sub, 0, ',', '.'); ?></td>
                                    <td class="text-center"><input class="form-check-input check-hapus" type="checkbox" name="hapus_item[]" value="<?php echo $it['item_code']; ?>" onchange="hitungTotalGeneral(this)"></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot class="table-light fw-bold fs-5">
                            <tr>
                                <td colspan="3" class="text-end py-3">TOTAL</td>
                                <td class="text-end text-primary text-price" id="totalAntrean<?php echo $safe_id; ?>">Rp <?php echo number_format($total_ant, 0, ',', '.'); ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary px-5">PROSES</button></div>
            </form>
        </div>
    </div>
</div>
<?php } ?>

<?php 
mysqli_data_seek($jurnal, 0);
while($j = mysqli_fetch_assoc($jurnal)) { 
    $id_j_modal = "DETAIL".substr($j['no_jurnal'], -6);
?>
<div class="modal fade" id="<?php echo $id_j_modal; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm"><div class="modal-content shadow border-0">
        <div class="modal-header"><h6 class="modal-title w-100 text-center">STRUK PENJUALAN<br><small><?php echo $j['no_jurnal']; ?></small></h6></div>
        <div class="modal-body p-3">
            <table class="table table-sm table-borderless small mb-0">
                <?php
                $nj = $j['no_jurnal'];
                $det = mysqli_query($koneksi, "SELECT d.*, b.item_name FROM penjualan_detail d JOIN daftar_barang b ON d.item_code = b.item_code WHERE d.no_jurnal = '$nj'");
                while($d = mysqli_fetch_assoc($det)) { echo "<tr><td>{$d['item_name']} x {$d['qty']}</td><td class='text-end'>".number_format($d['subtotal'],0,',','.')."</td></tr>"; }
                ?>
                <tr class="border-top fw-bold text-primary"><td>TOTAL</td><td class="text-end">Rp <?php echo number_format($j['total_bayar'], 0, ',', '.'); ?></td></tr>
            </table>
        </div>
        <div class="modal-footer justify-content-center"><button class="btn btn-dark btn-sm px-4" onclick="window.print()">Print</button></div>
    </div></div>
</div>
<?php } ?>

<script>
const formatRp = (v) => 'Rp ' + new Intl.NumberFormat('id-ID').format(v);

// LISTENER BARCODE ENTER
document.getElementById('inputBarcode').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') { e.preventDefault(); cariBarangBarcode(); }
});

function cariBarangBarcode() {
    const input = document.getElementById('inputBarcode');
    const code = input.value.trim();
    const qtyIn = document.getElementById('qtyBarcode');
    const feedback = document.getElementById('barcodeFeedback');

    if (!code) return;

    // CEK APAKAH SUDAH ADA DI TABEL
    let existingRow = null;
    document.querySelectorAll('#listPesananBaru .item-row').forEach(row => {
        if(row.querySelector('input[name="item_code[]"]').value === code) existingRow = row;
    });

    if (existingRow) {
        const inputQty = existingRow.querySelector('.input-qty');
        inputQty.value = parseInt(inputQty.value) + parseInt(qtyIn.value);
        feedback.innerHTML = `<span class="text-primary"><i class="fas fa-sync"></i> Qty ${code} diperbarui</span>`;
        input.value = ""; qtyIn.value = "1"; input.focus();
        hitungTotalGeneral(inputQty);
    } else {
        fetch(`cek_barcode.php?code=${code}`)
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                feedback.innerHTML = `<span class="text-danger"><i class="fas fa-times"></i> ${data.error}</span>`;
                input.select();
            } else {
                feedback.innerHTML = `<span class="text-success"><i class="fas fa-check"></i> ${data.item_name} OK</span>`;
                tambahBarisPesananBaru(data.item_code, data.item_name, data.harga, qtyIn.value);
                input.value = ""; qtyIn.value = "1"; input.focus();
            }
        });
    }
}

function tambahBarisPesananBaru(code, nama, harga, qty) {
    const tr = document.createElement('tr');
    tr.className = 'item-row';
    tr.innerHTML = `
        <td class="ps-3"><b>${nama}</b><br><small class="text-muted">${code}</small>
            <input type="hidden" name="item_code[]" value="${code}"></td>
        <td class="text-end text-price">${formatRp(harga)}<input type="hidden" class="harga-satuan" value="${harga}"></td>
        <td><input type="number" name="qty[]" class="form-control form-control-sm text-center input-qty" value="${qty}" onchange="hitungTotalGeneral(this)"></td>
        <td class="text-end fw-bold subtotal-text text-price">${formatRp(harga * qty)}</td>
        <td class="text-center"><button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove(); hitungTotalGeneral(this)"><i class="fas fa-trash"></i></button></td>
    `;
    document.getElementById('listPesananBaru').appendChild(tr);
    hitungTotalGeneral(tr);
}

function hitungTotalGeneral(el) {
    const modal = el.closest('.modal');
    let grandTotal = 0;
    modal.querySelectorAll('.item-row').forEach(row => {
        if (!row.querySelector('.check-hapus')?.checked) {
            const h = parseInt(row.querySelector('.harga-satuan').value);
            const q = parseInt(row.querySelector('.input-qty').value) || 0;
            const sub = h * q;
            row.querySelector('.subtotal-text').innerText = formatRp(sub);
            grandTotal += sub;
        } else { row.querySelector('.subtotal-text').innerText = formatRp(0); }
    });
    const d = modal.querySelector('[id^="total"]');
    if(d) d.innerText = formatRp(grandTotal);
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>