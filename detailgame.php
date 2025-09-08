<?php
session_start();
include "koneksi.php";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID game dari URL
$id_game = isset($_GET['id_game']) ? (int)$_GET['id_game'] : 0;

// Ambil data game berdasarkan ID
$sql = "SELECT id_game, nama_game, deskripsi, harga, foto_game, view, beli 
        FROM game 
        WHERE id_game = $id_game";
$result = $conn->query($sql);

// Jika game ditemukan
if ($result->num_rows > 0) {
    $game = $result->fetch_assoc();

    // Update view +1 ketika halaman detailgame dibuka
    $conn->query("UPDATE game SET view = view + 1 WHERE id_game = $id_game");
} else {
    echo "game tidak ditemukan.";
    exit;
}

// Jika tombol beli diklik
if (isset($_POST['beli'])) {
    $conn->query("UPDATE game SET beli = beli + 1 WHERE id_game = $id_game");

    // Popup setelah pembelian berhasil
    echo '<script type="text/javascript">
            alert("Terima kasih telah membeli game. Link download akan dikirimkan melalui email Anda.");
            window.location.href = "detailgame.php?id_game=' . $id_game . '";
          </script>';
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail game - <?php echo htmlspecialchars($game['nama_game']); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: #f0f0f0; padding: 20px; }
        .navbar { background-color: #333; overflow: hidden; }
        .navbar a { float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; }
        .navbar a:hover { background-color: #ddd; color: black; }
        .content { background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .product-title { font-size: 24px; margin-bottom: 20px; text-align: center; }
        .product-img { width: 100%; max-width: 400px; margin: 0 auto; display: block; border-radius: 10px; }
        .product-info { margin-top: 20px; text-align: center; }
        .product-info p { font-size: 16px; color: #555; }
        .product-info .price { font-size: 18px; font-weight: bold; color: #2575fc; margin-top: 10px; }
        .btn-buy { background-color: #2575fc; color: white; padding: 10px 20px; border-radius: 5px; text-align: center; cursor: pointer; margin-top: 20px; }
        .btn-buy:hover { background-color: #6a11cb; }
        .footer { background-color: #f2f2f2; padding: 20px; text-align: center; font-size: 14px; color: #666; margin-top: 40px; }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Beranda</a>
    <a href="cari.php">Pencarian</a>
    <a href="kategori.php">Kategori</a>
    <a href="daftargame.php">Daftar Game</a>
    <a href="login.php">Login</a>
</div>

<div class="content">
    <h2 class="product-title"><?php echo htmlspecialchars($game['nama_game']); ?></h2>
    <img class="product-img" src="img/game/<?php echo htmlspecialchars($game['foto_game']); ?>" alt="<?php echo htmlspecialchars($game['nama_game']); ?>">
    
    <div class="product-info">
        <p><?php echo nl2br(htmlspecialchars($game['deskripsi'])); ?></p>
        <p class="price">Rp<?php echo number_format($game['harga'], 2, ',', '.'); ?></p>
        <p>Jumlah view: <?php echo $game['view']; ?> | Jumlah beli: <?php echo $game['beli']; ?></p>
        
        <!-- Tombol Beli -->
        <form method="POST">
            <button type="submit" name="beli" class="btn-buy">Beli</button>
        </form>
    </div>
</div>

<div class="footer">
    <p>© 2024 Toko Game | <a href="biodata.html">Tentang</a></p>
</div>

</body>
</html>
