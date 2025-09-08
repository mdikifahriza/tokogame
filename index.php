<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Game</title>
    <style>
        /* Reset styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f0f0f0;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        table {
            width: 100%;
            height: 100vh;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 20px;
        }

        /* Styling untuk header */
        .header {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        /* Styling konten utama */
        .content {
            background: url('img/img.jpg') no-repeat center center;
            background-size: cover;
            padding: 20px;
            border-radius: 10px;
            color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            height: 300px;
        }

        .game-description {
            font-size: 18px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        .game-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 10px;
            width: 220px;
            display: inline-block;
            vertical-align: top;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .game-card:hover {
            transform: scale(1.05);
        }

        .game-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .game-card .game-info {
            padding: 15px;
        }

        .game-card .game-info h3 {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .game-card .game-info p {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }

        .game-card .game-info .game-price {
            font-size: 16px;
            font-weight: bold;
            color: #2575fc;
        }

        .footer {
            background-color: #f2f2f2;
            padding: 20px;
            font-size: 14px;
            color: #666;
        }

        .footer a {
            color: #2575fc;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .button {
            margin: 20px auto;
            display: block;
            padding: 10px 20px;
            background-color: #2575fc;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
        }

        .button:hover {
            background-color: #6a11cb;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="index.php">Beranda</a>
        <a href="cari.php">Pencarian</a>
        <a href="kategori.php">Kategori</a>
        <a href="daftargame.php">Daftar Game</a>
        <a href="login.php">Login</a>
    </div>

    <table>
        <!-- Baris 1: Header -->
        <tr>
            <td class="header" colspan="2">Toko Game</td>
        </tr>

        <!-- Baris 2: Konten Utama -->
        <tr>
            <td rowspan="2" class="content">
                <div class="game-description">
                    <p>Selamat datang di Toko Game! Temukan berbagai game terbaik untuk dimainkan atau dibeli di sini.</p>
                    <p><strong>Petunjuk:</strong> Pilih game yang Anda suka dan klik untuk membeli atau melihat detail lebih lanjut.</p>
                </div>
            </td>
            <td>
    <h3>Game Populer</h3>
    <!-- Game Cards -->
    <?php
    include 'koneksi.php';  // Include the database connection file

    $sql = "SELECT game.id_game, game.nama_game, game.harga, kategori.nama_kategori, game.foto_game, game.beli
            FROM game 
            JOIN kategori ON game.id_kategori = kategori.id_kategori
            ORDER BY game.beli DESC
            LIMIT 6";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $nama_game = strlen($row['nama_game']) > 20 ? substr($row['nama_game'], 0, 20) . '...' : $row['nama_game'];
            // Perbaiki bagian ini agar link menuju ke halaman detailgame.php dengan id_game
            echo '<div class="game-card" onclick="window.location.href=\'detailgame.php?id_game=' . $row['id_game'] . '\'">';
            echo '<img src="img/game/' . $row['foto_game'] . '" alt="' . $nama_game . '">';
            echo '<div class="game-info">';
            echo '<h3>' . $nama_game . '</h3>';
            echo '<p class="game-price">Rp' . number_format($row['harga'], 2, ',', '.') . '</p>';
            echo '<p>Kategori: ' . $row['nama_kategori'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Tidak ada game yang tersedia.</p>';
    }

    mysqli_close($conn);
    ?>
    <a href="daftargame.php" class="button">Daftar game</a>
</td>

        </tr>

        <tr>
            <td></td>
        </tr>

        <!-- Baris 3: Footer -->
        <tr>
            <td colspan="2" class="footer">
                <p>© 2024 Toko Game | <a href="biodata.html">Tentang</a></p>
            </td>
        </tr>
    </table>
</body>
</html>
