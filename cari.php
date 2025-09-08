<?php
session_start();
include "koneksi.php";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

$sql = "SELECT p.id_game, p.nama_game, p.deskripsi, p.harga, p.foto_game, k.nama_kategori 
        FROM game p 
        LEFT JOIN kategori k ON p.id_kategori = k.id_kategori 
        WHERE p.nama_game LIKE '%$query%' OR p.deskripsi LIKE '%$query%' OR k.nama_kategori LIKE '%$query%' 
        ORDER BY p.nama_game ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Toko Game</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: #f0f0f0; }
        .navbar { background-color: #333; overflow: hidden; }
        .navbar a { float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; }
        .navbar a:hover { background-color: #ddd; color: black; }
        .content { padding: 20px; }
        .search-box { margin: 20px 0; display: flex; justify-content: center; }
        .search-box input[type="text"] { padding: 10px; width: 300px; border: 1px solid #ddd; border-radius: 5px; }
        .search-box button { padding: 10px 20px; margin-left: 10px; background-color: #2575fc; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .search-box button:hover { background-color: #6a11cb; }
        .game-card { background-color: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin: 10px; width: 220px; display: inline-block; text-align: left; }
        .game-card img { width: 100%; height: 180px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px; }
        .game-card .game-info { padding: 15px; }
        .game-card .game-info h3 { font-size: 14px; margin-bottom: 10px; }
        .game-card .game-info p { font-size: 14px; color: #555; margin-bottom: 15px; }
        .game-results { display: flex; justify-content: center; align-items: center; flex-wrap: wrap; margin-top: 20px;}
        .game-card .game-info .game-price { font-size: 16px; font-weight: bold; color: #2575fc; }
        .footer { background-color: #f2f2f2; padding: 20px; text-align: center; font-size: 14px; color: #666; }
        .button-back { margin: 20px auto; display: block; padding: 10px 20px; background-color: #2575fc; color: white; text-align: center; border-radius: 5px; text-decoration: none; }
        .button-back:hover { background-color: #6a11cb; }
        h2 { text-align: center; margin-top: 20px;}
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
    <form class="search-box" method="GET" action="cari.php">
        <input type="text" name="query" placeholder="Cari game..." value="<?php echo htmlspecialchars($query); ?>">
        <button type="submit">Cari</button>
    </form>

    <h2>Hasil Pencarian untuk: "<?php echo htmlspecialchars($query); ?>"</h2>
    <div class="game-results">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $nama_game = strlen($row['nama_game']) > 20 ? substr($row['nama_game'], 0, 20) . '...' : $row['nama_game'];
                echo '<a href="detailgame.php?id_game=' . $row['id_game'] . '">';
                echo '<div class="game-card">';
                echo '<img src="img/game/' . $row['foto_game'] . '" alt="' . $nama_game . '">';
                echo '<div class="game-info">';
                echo '<h3>' . $nama_game . '</h3>';
                echo '<p class="game-price">Rp' . number_format($row['harga'], 2, ',', '.') . '</p>';
                echo '<p>Kategori: ' . $row['nama_kategori'] . '</p>';
                echo '</div></div>';
                echo '</a>';
            }
        } else {
            echo '<p>Tidak ada game yang tersedia.</p>';
        }
        ?>
    </div>
</div>
<div class="footer">
    <p>© 2024 Toko Game | <a href="biodata.html">Tentang</a></p>
</div>

</body>
</html>
