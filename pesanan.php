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

    if (isset($_SESSION['username'])) {
     $username = $_SESSION['username'];

     $pesanan = mysqli_query($conn, "SELECT * FROM pesanan WHERE username = '$username'"); 

  }

$total_pesanan = mysqli_num_rows($pesanan);

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
            padding: 5px 10px;
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
                <li><a href="logout.php" class="btn" style="border-bottom: none;">Logout</a></li>
            </ul>
        </nav>
        <div class="jumbotron">
            <h3>Game Store <i class="fab fa-accusoft"></i></h3>
            <p>Happy Shopping,
            <?php
                    if (isset($_SESSION['username'])) {
                     $username = $_SESSION['username'];

                     $query = mysqli_query($conn, "SELECT nama FROM user WHERE username = '$username'"); 
                     foreach ($query as $cf) {}

                     if($query->num_rows > 0) {
                      echo $cf['nama'];
                      }
                  }
                ?> :)
            </p>
        </div>
    </header>

    <main>
         <article class="card">
                <center><h3 style="color:royalblue;">Pesanan Saya</h3></center>
        </article>

        <div id="content">
            <?php foreach ($pesanan as $cf) : ?>
            <div class="flex">
                <div class="card">
                      <center><h4><?= $cf["produk"]; ?></h4></center>
                      <p>Nama Penerima : <b><?= $cf["nama_penerima"]; ?></b></p>
                      <p>Alamat Penerima : <b><?= $cf["alamat_penerima"]; ?></b></p>
                      <p>Nomor Handphone : <b><?= $cf["nohp_penerima"]; ?></b></p>
                      <p>Estimasi Produk Sampai : <b><?= $cf["tanggal"]; ?></b></p>
                      <p>Total Pembayaran : <span class="harga">Rp<?= number_format($cf['total_bayar'],2,',','.'); ?></span></p>
                      <p>Status : <b style="color: royalblue;"><?= $cf["status_pesanan"]; ?></b></p>
               </div>
            </div>
            <?php endforeach; ?>
        </div>

        <aside>
            <div class="card">
                <center><p>Total Pesanan Saya : <b><span style="color: #royalblue;"><?= $total_pesanan; ?></span></b></p></center>
            </div>
        </aside>
           
    </main>

    <?php include 'footer.php'; ?> 
     
</body>
</html>