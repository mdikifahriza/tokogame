<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_admin'])) {
    die(json_encode(['success' => false, 'message' => 'Session id_admin tidak ditemukan.']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_kategori'])) {
        die(json_encode(['success' => false, 'message' => 'ID Kategori tidak ditemukan.']));
    }

    $id_kategori = $_POST['id_kategori'];

    // Ambil semua game yang terkait dengan kategori ini
    $game_sql = "SELECT * FROM game WHERE id_kategori = ?";
    $game_stmt = $conn->prepare($game_sql);
    $game_stmt->bind_param("i", $id_kategori);
    $game_stmt->execute();
    $game_result = $game_stmt->get_result();

    // Hapus file foto untuk setiap game
    while ($game = $game_result->fetch_assoc()) {
        $file_path = "img/game/" . $game['foto_game'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    $game_stmt->close();

    // Hapus semua game yang terkait dengan kategori ini
    $delete_games_sql = "DELETE FROM game WHERE id_kategori = ?";
    $delete_games_stmt = $conn->prepare($delete_games_sql);
    $delete_games_stmt->bind_param("i", $id_kategori);
    $delete_games_stmt->execute();
    $delete_games_stmt->close();

    // Hapus kategori itu sendiri
    $delete_category_sql = "DELETE FROM kategori WHERE id_kategori = ?";
    $delete_category_stmt = $conn->prepare($delete_category_sql);
    $delete_category_stmt->bind_param("i", $id_kategori);

    if ($delete_category_stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }

    $delete_category_stmt->close();
    exit;
}
