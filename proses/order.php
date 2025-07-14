<?php
include '../koneksi.php';

$kode_cs = $_POST['kode_cs'];
$nama = $_POST['nama'];
$provinsi = $_POST['prov'];
$kota = $_POST['kota'];
$alamat = $_POST['almt'];
$kode_pos = $_POST['kopos'];
$grand_total = $_POST['grand_total'];
$metode = $_POST['metode_pembayaran'];

// update alamat customer
mysqli_query($conn, "UPDATE customer SET 
	provinsi='$provinsi',
	kota='$kota',
	alamat='$alamat',
	kode_pos='$kode_pos'
	WHERE kode_customer='$kode_cs'
");

// simpan ke transaksi
mysqli_query($conn, "INSERT INTO transaksi 
	(kode_customer, tanggal, total, metode_pembayaran) 
	VALUES 
	('$kode_cs', NOW(), '$grand_total', '$metode')
");

$id_transaksi = mysqli_insert_id($conn);

// ambil isi keranjang
$keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE kode_customer = '$kode_cs'");

while($row = mysqli_fetch_assoc($keranjang)){
	$id_produk = $row['id_produk'];
	$qty = $row['qty'];
	$sub_total = $row['harga'] * $qty;

	// simpan detail transaksi
	mysqli_query($conn, "INSERT INTO transaksi_detail 
		(id_transaksi, id_produk, qty, sub_total)
		VALUES
		('$id_transaksi', '$id_produk', '$qty', '$sub_total')
	");
}

// kosongkan keranjang
mysqli_query($conn, "DELETE FROM keranjang WHERE kode_customer = '$kode_cs'");

// redirect ke halaman struk
header("Location: ../selesai.php");
exit;
