<?php 
include 'header.php';
$kd = mysqli_real_escape_string($conn,$_GET['kode_cs']);
$cs = mysqli_query($conn, "SELECT * FROM customer WHERE kode_customer = '$kd'");
$rows = mysqli_fetch_assoc($cs);
?>

<div class="container" style="padding-bottom: 200px">
	<h2 style=" width: 100%; border-bottom: 4px solid #ff8680"><b>Checkout</b></h2>
	<div class="row">
		<div class="col-md-6">
			<h4>Daftar Pesanan</h4>
			<table class="table table-stripped">
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Harga</th>
					<th>Qty</th>
					<th>Sub Total</th>
				</tr>
				<?php 
				$result = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kd'");
				$no = 1;
				$hasil = 0;
				while($row = mysqli_fetch_assoc($result)){
					?>
					<tr>
						<td><?= $no; ?></td>
						<td><?= $row['nama_produk']; ?></td>
						<td>Rp.<?= number_format($row['harga']); ?></td>
						<td><?= $row['qty']; ?></td>
						<td>Rp.<?= number_format($row['harga'] * $row['qty']);  ?></td>
					</tr>
					<?php 
					$total = $row['harga'] * $row['qty'];
					$hasil += $total;
					$no++;
				}
				?>
				<tr>
					<td colspan="5" style="text-align: right; font-weight: bold;">Grand Total = Rp.<?= number_format($hasil); ?></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 bg-success">
			<h5>Pastikan Pesanan Anda Sudah Benar</h5>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6 bg-warning">
			<h5>Isi Form dibawah ini</h5>
		</div>
	</div>
	<br>
	<form action="proses/order.php" method="POST">
		<input type="hidden" name="kode_cs" value="<?= $kd; ?>">
		<input type="hidden" name="grand_total" value="<?= $hasil; ?>">

		<div class="form-group">
			<label for="exampleInputEmail1">Nama</label>
			<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama" name="nama" style="width: 557px;" value="<?= $rows['nama']; ?>" readonly>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="provinsi">Provinsi</label>
					<input type="text" class="form-control" id="provinsi" placeholder="Provinsi" name="prov">
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="kota">Kota</label>
					<input type="text" class="form-control" id="kota" placeholder="Kota" name="kota">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="alamat">Alamat</label>
					<input type="text" class="form-control" id="alamat" placeholder="Alamat" name="almt">
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="kode_pos">Kode Pos</label>
					<input type="text" class="form-control" id="kode_pos" placeholder="Kode Pos" name="kopos">
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="metode_pembayaran">Metode Pembayaran</label>
			<select name="metode_pembayaran" class="form-control" style="width: 557px;" required>
				<option value="">-- Pilih Metode --</option>
				<option value="Transfer Bank">Transfer Bank</option>
				<option value="COD">Cash on Delivery (COD)</option>
				<option value="QRIS">QRIS</option>
			</select>
		</div>

		<button type="submit" class="btn btn-success">
			<i class="glyphicon glyphicon-shopping-cart"></i> Order Sekarang
		</button>
		<a href="keranjang.php" class="btn btn-danger">Cancel</a>
	</form>
</div>

<?php 
include 'footer.php';
?>
