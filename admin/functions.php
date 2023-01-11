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

function tambah($data) {
	global $conn;

	// htmlspecialchars berfungsi untuk tidak menjalankan script
	$tgl_produksi = htmlspecialchars($data["tgl_produksi"]);
	$nama = htmlspecialchars($data["nama"]);
	$kode = htmlspecialchars($data["kode"]);
	$deskripsi = htmlspecialchars($data["deskripsi"]);
	$harga = htmlspecialchars($data["harga"]);
	$stok = htmlspecialchars($data["stok"]);
	$status = htmlspecialchars($data["status"]);

	$gambar = upload();


		// tambahkan ke database
		// NULL digunakan karena jika dikosongkan maka akan terjadi error di database yang sudah online
		// sedangkan jika masih di localhost, bisa memakai ''
	mysqli_query($conn, "INSERT INTO produk VALUES(NULL, '$kode', '$gambar', '$tgl_produksi', '$nama', '$deskripsi', '$harga', '$status')");
	mysqli_query($conn, "INSERT INTO gudang VALUES(NULL, '$kode', '$stok')");
	return mysqli_affected_rows($conn);
}


function hapusitem($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM produk WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function hapuspesanan($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM pesanan WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function ubah($data) {
	global $conn;
     
    $id = $data["id"];
    $kode = $data["kode"];
    $gambar = $data["gambar"];
    $tgl_produksi = $data["tgl_produksi"];
    $nama = $data["nama"];
	$deskripsi = $data["deskripsi"];
	$harga = $data["harga"];
	$status = $data["status"];

	$query = "UPDATE produk SET 
				kode = '$kode',
				gambar = '$gambar',
				tgl_produksi = '$tgl_produksi',
				nama = '$nama',
				deskripsi = '$deskripsi',
				harga = '$harga',
				status = '$status'
			  WHERE id = $id
			";
			
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubahstok($data) {
	global $conn;
     
    $id = $data["id"];
    $kode = $data["kode"];
	$stok = $data["stok"];

	$query = "UPDATE gudang SET 
				kode = '$kode',
				stok = '$stok'
			  WHERE id = $id
			";
			
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubahdata($data) {
    global $conn;
     
    $id = $data["id"];
    $status_pesanan =  $data["status_pesanan"];

    $query = "UPDATE pesanan SET 
                status_pesanan = '$status_pesanan'
              WHERE id = $id
            ";
            
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubahgambar($data) {
	global $conn;
     
    $id = $data["id"];

	$gambar = upload();


	$query = "UPDATE produk SET 
				gambar = '$gambar'
			  WHERE id = $id
			";
			
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function upload() {
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];


    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName, '../images/' . $namaFileBaru);

    return $namaFileBaru;
}