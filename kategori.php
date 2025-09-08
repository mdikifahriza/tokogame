<?php
include "koneksi.php";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql_kategori = "SELECT id_kategori, nama_kategori FROM kategori ORDER BY kategori.nama_kategori ASC";
$result_kategori = $conn->query($sql_kategori);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Toko Game</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: #f0f0f0; text-align: center; }
        .navbar { background-color: #333; overflow: hidden; }
        .navbar a { float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; }
        .navbar a:hover { background-color: #ddd; color: black; }
        .content { padding: 20px; }
        .category-container { margin: 20px auto; text-align: center; display: flex; justify-content: center; flex-wrap: wrap; gap: 20px; }
        .select-category { margin-bottom: 20px; }
        .game-card { background-color: #fff; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin: 10px; width: 220px; display: inline-block; overflow: hidden; text-align: left; }
        .game-card img { width: 100%; height: 180px; object-fit: cover; }
        .game-card .game-info { padding: 15px; }
        .game-card .game-info h3 { font-size: 14px; margin-bottom: 10px; }
        .game-card .game-info p { font-size: 14px; color: #555; margin-bottom: 15px; }
        .game-card .game-info .game-price { font-size: 16px; font-weight: bold; color: #2575fc; }
        .game-card a { text-decoration: none; color: inherit; }
        .button { margin: 10px; padding: 10px 20px; background-color: #2575fc; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; }
        .button:hover { background-color: #6a11cb; }
        .footer { background-color: #f2f2f2; padding: 20px; text-align: center; font-size: 14px; color: #666; }
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
    <h2>Kategori Game</h2>

    <div class="select-category">
        <form method="GET" action="kategori.php">
            <select name="id_kategori">
                <?php
                if ($result_kategori->num_rows > 0) {
                    while($kategori = $result_kategori->fetch_assoc()) {
                        echo '<option value="' . $kategori['id_kategori'] . '">' . $kategori['nama_kategori'] . '</option>';
                    }
                }
                ?>
            </select>
            <button type="submit" class="button">Pilih</button>
        </form>
    </div>

    <div class="category-container">
        <?php
        if (isset($_GET['id_kategori'])) {
            $id_kategori = $_GET['id_kategori'];
            $sql_game = "SELECT id_game, nama_game, harga, foto_game FROM game WHERE id_kategori = $id_kategori";
            $result_game = $conn->query($sql_game);

            if ($result_game->num_rows > 0) {
                while($game = $result_game->fetch_assoc()) {
                    $nama_game = strlen($game['nama_game']) > 20 ? substr($game['nama_game'], 0, 20) . '...' : $game['nama_game'];
                    echo '<a href="detailgame.php?id_game=' . $game['id_game'] . '">';
                    echo '<div class="game-card">';
                    echo '<img src="img/game/' . $game['foto_game'] . '" alt="' . $nama_game . '">';
                    echo '<div class="game-info">';
                    echo '<h3>' . $nama_game . '</h3>';
                    echo '<p class="game-price">Rp' . number_format($game['harga'], 2, ',', '.') . '</p>';
                    echo '</div></div>';
                    echo '</a>';
                }
            } else {
                echo '<p>Tidak ada game dalam kategori ini.</p>';
            }
        }
        ?>
    </div>
</div>

<div class="footer">
    <p>© 2024 Toko Game | <a href="biodata.html">Tentang</a></p>
</div>

</body>
</html>
