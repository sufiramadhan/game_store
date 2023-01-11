<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "game_store");

function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	};
	return $rows;
};

function registrasi($data) {
	global $conn;

	$username = mysqli_real_escape_string($conn, $data["username"]);
	$password_sebelum = mysqli_real_escape_string($conn, $data["password"]);
	$nama = mysqli_real_escape_string($conn, $data["nama"]);

	// cek username admin sudah ada atau belum

	$cekusernameadmin = "SELECT * FROM admin where username='$username'";
	$prosescek= mysqli_query($conn, $cekusernameadmin);

	if (mysqli_num_rows($prosescek)>0) { 
	    echo "<script>alert('Username Sudah Digunakan!');history.go(-1) </script>";
	    exit;
	}

	// cek username user sudah ada atau belum

	$cekusernameuser = "SELECT * FROM user where username='$username'";
	$prosescek= mysqli_query($conn, $cekusernameuser);

	if (mysqli_num_rows($prosescek)>0) { 
	    echo "<script>alert('Username Sudah Digunakan!');history.go(-1) </script>";
	    exit;
	}

	// enkripsi password
	$password = password_hash($password_sebelum, PASSWORD_DEFAULT);

	// Masukkan Data ke Database
	mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password', '$nama')");
	return mysqli_affected_rows($conn);
}


function pesanan($data) {
	global $conn;

	$username = mysqli_real_escape_string($conn, $data["username"]);
	$produk = mysqli_real_escape_string($conn, $data["produk"]);
	$nama_penerima = mysqli_real_escape_string($conn, $data["nama_penerima"]);
	$alamat_penerima = mysqli_real_escape_string($conn, $data["alamat_penerima"]);
	$nohp_penerima = mysqli_real_escape_string($conn, $data["nohp_penerima"]);
	$tanggal = $data["tanggal"];
	$total_bayar = mysqli_real_escape_string($conn, $data["total_bayar"]);
	$status = mysqli_real_escape_string($conn, $data["status"]);

	// Masukkan Data ke Database
	mysqli_query($conn, "INSERT INTO pesanan VALUES('', '$username',  '$produk', '$nama_penerima', '$alamat_penerima', '$nohp_penerima', '$tanggal', '$total_bayar', '$status')");
	return mysqli_affected_rows($conn);
}