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

$produk = mysqli_query($conn, "SELECT * FROM produk");
$total_produk = mysqli_num_rows($produk);

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
    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="pesanan.php">Pesanan Saya</a></li>
                <li><a href="tentang.php">Tentang Kami</a></li>
                <li><a href="logout.php" class="btn" style="border-bottom: none;">Logout</a></li>
            </ul>
        </nav>
        <div class="jumbotron">
            <h3>Game Store <i class="fab fa-accusoft"></i></h3>
            <p>Hai,
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
         <article class="card">
                <center><h3 style="color:royalblue;">Katalog Produk</h3></center>
        </article>

        <div id="content">
            <?php foreach ($produk as $p) : ?>
            <div class="flex">
                <div class="card">
                    <center>
                    <img src="images/<?= $p["gambar"]; ?>" class="featured-image">
                    <h4><?= $p["nama"]; ?></h4>
                    <p><a href="produk.php?id=<?= $p["id"]; ?>" class="btn btn-beli">Lihat Detail</a></p>
                    </center>
               </div>
            </div>
            <?php endforeach; ?>
        </div>

        <aside>
            <div class="card">
                <center><p>Total Katalog : <b><span style="color: #royalblue;"><?= $total_produk; ?></span></b></p></center>
            </div>
        </aside>
           
    </main>

    <?php include 'footer.php'; ?>
    
</body>
</html>