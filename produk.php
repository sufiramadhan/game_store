<?php 
session_start();

if (isset($_SESSION["admin"])) {
  echo "<script>
         window.location.replace('admin');
       </script>";
  exit;
}
if (!isset($_SESSION['user'])) {
   echo "<script>
         window.location.replace('login.php');
       </script>";
  exit;
}
require 'functions.php';

$id = $_GET["id"];
$produk = query("SELECT * FROM produk WHERE id = $id")[0];

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$ongkir = $produk["harga"] * 35 / 100;
$total_bayar = $produk["harga"] + $ongkir;

$time_sekarang = time();
$tanggal = date("d F Y", strtotime("+4 days", $time_sekarang));

if (isset($_POST["pesan"])) {
  if (pesanan($_POST) > 0 ) {
    echo "<script>
        alert('Produk Berhasil di Pesan!');
        window.location.href='pesanan.php';
    </script>";
  } else {
    echo mysqli_error($conn);
  }
 }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Icon dari Fontawesome -->
    <script src="https://kit.fontawesome.com/348c676099.js" crossorigin="anonymous"></script>
    <title>Game Store</title>
    <style>
        .btn {
            text-decoration: none;
            padding: 10px;
            background-color: red;
        }
        .flex {
            display: flex;
            flex-direction: column;
        }
        .btn-beli {
            text-decoration: none;
            padding: 5px 10px;
            background-color: green;
        }
        #content {
            width: 55%;
        }
        aside {
            width: 45%;
        }
        .alert {
            margin: 10px 0;
            font-size: 0.9rem;
            background-color: #FCC663;
            padding: 10px;
            border: 1px solid darkorange;
        }
        .harga {
            padding: 5px;
            border-radius: 5px;
            color: green;
            background-color: #90DE90;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="katalog.php">Katalog</a></li>
                <li><a href="pesanan.php">Pesanan Saya</a></li>
                <li><a href="logout.php" class="btn" style="border-bottom: none;">Logout</a></li>
            </ul>
        </nav>
        <div class="jumbotron">
            <h3>Game Store <i class="fab fa-accusoft"></i></h3>
            <p>Stay Safe,
            <?php
                    if (isset($_SESSION['username'])) {
                     $username = $_SESSION['username'];

                     $query = mysqli_query($conn, "SELECT nama FROM user WHERE username = '$username'"); 
                     foreach ($query as $cf) {}

                     if($query->num_rows > 0) {
                      echo $cf['nama'];
                      }
                  }
                ?>
            </p>
        </div>
    </header>

    <main>

        <div id="content">
                <div class="card">
                    <center>
                    <img src="images/<?= $produk["gambar"]; ?>" class="featured-image">
                    <h4><?= $produk["nama"]; ?></h4>
                    <p><?= $produk["deskripsi"]; ?></p>
                    <p>Harga : Rp<?= number_format($produk['harga'],2,',','.'); ?></p>
                    <p>Diproduksi : <?= $produk["tgl_produksi"]; ?></p>
                    <p style="color: green"><?= $produk["status"]; ?></p>
                    </center>
               </div>
        </div>

        <aside>
            <div class="card">
                <form action="" method="post">
                 <input type="hidden" id="username" name="username" value="<?= $username; ?>" required>
                 <input type="hidden" id="produk" name="produk" value="<?= $produk["nama"]; ?>" required>
                 <input type="hidden" id="tanggal" name="tanggal" value="<?= $tanggal; ?>" required>
                 <input type="hidden" id="status" name="status" value="Sedang Diproses" required>
                 <input type="hidden" id="total_bayar" name="total_bayar" value="<?= $total_bayar; ?>" required>
                    <center><h4>Format Pemesanan</h4></center>
                    <div class="alert">Pastikan semua data yang anda isi sudah benar, sebelum klik tombol pesan.</div>
                     <div class="alert" style="padding: 1px 10px;"><p style="color: white;">Pengiriman memerlukan waktu 4 hari kalender paling lama <i class="fas fa-exclamation-circle"></i></p></div>
                    <br>
                    <div class="jarak">
                         <label for="nama_penerima">Nama Penerima</label>
                         <input type="text" id="nama_penerima" name="nama_penerima" placeholder="Masukkan Nama Penerima" required>
                    </div>
                    <div class="jarak">
                         <label for="alamat_penerima">Alamat Penerima</label>
                         <input type="text" id="alamat_penerima" name="alamat_penerima" placeholder="Masukkan Alamat Penerima" required>
                    </div>
                    <div class="jarak">
                         <label for="nohp_penerima">Nomor Handphone Penerima</label>
                         <input type="number" id="nohp_penerima" name="nohp_penerima" placeholder="Masukkan Nomor Handphone Penerima" required>
                    </div>
                    <div class="jarak">
                         <label for="tanggal">Estimasi Produk Sampai Tujuan</label>
                         <p><span class="harga" style="background-color: #FBD388;color: #D37401;"><?= $tanggal; ?></span></p>
                    </div>
                    <div class="jarak">
                         <label for="ongkir">Ongkos Kirim</label>
                         <input type="text" id="ongkir" name="ongkir" value="<?= $ongkir; ?>" disabled required>
                    </div>
                    <div class="jarak">
                         <label for="total_bayar">Total Pembayaran</label>
                         <p><span class="harga"><?= $total_bayar; ?></span></p>
                    </div>
                    <button type="submit" name="pesan" class="btn" style="width: 100%;background-color: green;">Pesan Sekarang</button>
                </form>
            </div>
            <a href="katalog.php">
            <div class="card">
                <center><p>Kembali ke Katalog</p></center>
            </div>
            </a>
        </aside>
           
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>