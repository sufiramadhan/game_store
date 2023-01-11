<?php 
session_start();

if (!isset($_SESSION['admin'])) {
   echo "<script>
         window.location.replace('../login.php');
       </script>";
  exit;
}

require 'functions.php';


$id = $_GET["id"];
$pesanan = query("SELECT * FROM pesanan WHERE id = $id")[0];

if (isset($_POST["submit"])) {

  if (ubahdata($_POST) > 0 ) {
    echo "
      <script>
        alert('Data Berhasil Diubah!');
        window.location.href='index.php';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('Data Gagal Diubah!');
        
      </script>
    ";
  }
} 
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
        #content {
            width: 100%;
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
        <div class="jumbotron">
            <h3>Game Store <i class="fab fa-accusoft"></i></h3>
        </div>
    </header>

   <main>
        <div id="content">
            <h2 class="judul">Ubah Status</h2>
            <article class="card">
                <form action="" method="post" enctype="multipart/form-data">
                 <input type="hidden" id="id" name="id" value="<?= $pesanan['id']; ?>">
                    <div class="jarak">
                         <label for="status_pesanan">Status</label>
                         <input type="radio" id="status_pesanan" name="status_pesanan" value="Sedang Diproses" required>Sedang Diproses
                         <input type="radio" id="status_pesanan" name="status_pesanan" value="Dalam Perjalanan
                         " required>Dalam Perjalanan
                         <input type="radio" id="status_pesanan" name="status_pesanan" value="Telah Tiba" required>Telah Tiba
                    </div>
                    <button type="submit" name="submit" class="btn" style="width: 100%;background-color: green;padding: 10px;">Ubah</button>
                </form>
            </article>
        </div>
    </main>
    

    <?php include '../footer.php'; ?>

</body>
</html>