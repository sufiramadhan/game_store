<?php 
session_start();

if (!isset($_SESSION['admin'])) {
   echo "<script>
         window.location.replace('../login.php');
       </script>";
  exit;
}

require 'functions.php';

  $pesanan = mysqli_query($conn, "SELECT * FROM pesanan");
  
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <title>Game Store</title>
    <style>
        .btn {
            text-decoration: none;
            padding: 3px 10px;
            background-color: darkred;
        } 
    </style>
</head>

<body>
     <header>
        <nav>
            <ul>
                <li><a href="index.php">Data produk</a></li>
                <li><a href="../logout.php" class="btn" style="border-bottom: none;">Logout</a></li>
            </ul>
        </nav>
        <div class="jumbotron">
            <h3>Game Store <i class="fab fa-accusoft"></i></h3>
        </div>
    </header>

    <main>
         <article class="card">
                <center><h3 style="color:royalblue;">Data Pesanan</h3></center>
        </article>

        <div id="content">
            <?php foreach ($pesanan as $user) : ?>
            <div class="flex">
                <div class="card">
                    <center>
                    <h4>Username : <?= $user["username"]; ?></h4>
                    <p>Produk : <b><?= $user["produk"]; ?></b></p>
                    <p>Nama Penerima : <b><?= $user["nama_penerima"]; ?></b></p>
                    <p>Alamat Penerima : <b><?= $user["alamat_penerima"]; ?></b></p>
                    <p>Nomor Handphone Penerima : <b><?= $user["nohp_penerima"]; ?></b></p>
                    <p>Estimasi Produk Sampai : <b><?= $user["tanggal"]; ?></b></p>
                    <p>Total Pembayaran : <b>Rp<?= number_format($user['total_bayar'],2,',','.'); ?></b></p>
                    <p>Status : <b><?= $user["status_pesanan"]; ?></b></p>                    <p><a href="edit-pesanan.php?id=<?= $user["id"]; ?>" class="btn" style="background-color: orange;">Ubah Status</a></p>
                    <p><a href="hapus-pesanan.php?id=<?= $user["id"]; ?>" class="btn">Hapus</a></p>
                    </center>
               </div>
            </div>
            <?php endforeach; ?>
        </div>

        <aside>
            <a href="index.php" style="text-decoration: none;"><div class="card">
                <center><p>Kembali ke Beranda</p></center>
            </div></a>
        </aside>
           
    </main>

    
    <?php include '../footer.php'; ?>


</body>
</html>