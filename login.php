<?php
session_start();
include "koneksi.php"; // Menghubungkan dengan file koneksi

$error = ""; // Variabel untuk menyimpan pesan error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi.";
    } else {
        // Query untuk memeriksa username dan password
        $sql = "SELECT id_admin, username FROM admin WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameter
            $stmt->bind_param("ss", $username, $password);

            // Eksekusi statement
            $stmt->execute();

            // Ambil hasil
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Ambil data admin dan set sesi
                $row = $result->fetch_assoc();
                $_SESSION['id_admin'] = $row['id_admin']; // Set id_admin ke sesi
                $_SESSION['username'] = $row['username']; // Set username ke sesi
                header("Location: rubahgame.php");
                exit;
            } else {
                $error = "Username atau password salah.";
            }

            // Tutup statement
            $stmt->close();
        } else {
            $error = "Terjadi kesalahan pada server. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style> 
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #2575fc, #6a11cb);
    color: #333;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.navbar {
    width: 100%;
    background-color: #333;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    z-index: 1000;
}

.navbar a {
    float: left;
    display: block;
    color: white;
    text-align: center;
    padding: 14px 20px;
    text-decoration: none;
    transition: background-color 0.3s, color 0.3s;
}

.navbar a:hover {
    background-color: #6a11cb;
    color: white;
}

.content {
    background: #fff;
    padding: 30px 20px;
    max-width: 400px;
    margin-top: 80px;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    text-align: center;
    width: 90%;
    animation: fadeIn 0.8s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.content h2 {
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.form-group input:focus {
    border-color: #2575fc;
    outline: none;
}

.form-group button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #2575fc, #6a11cb);
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}

.form-group button:hover {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    transform: translateY(-2px);
}

.error-message {
    color: red;
    margin-bottom: 20px;
    font-weight: bold;
}

.footer {
    margin-top: 20px;
    background-color: #f9f9f9;
    padding: 10px 20px;
    text-align: center;
    font-size: 14px;
    color: #666;
    border-top: 1px solid #ddd;
    width: 100%;
    position: fixed;
    bottom: 0;
    left: 0;
}
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
    <h2>Login</h2>
    <?php if (!empty($error_message)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password">
        </div>
        <div class="form-group">
            <button type="submit">Login</button>
        </div>
    </form>
</div>

<div class="footer">
    <p>© 2024 Toko Game | <a href="biodata.html">Tentang</a></p>
</div>

</body>
</html>
