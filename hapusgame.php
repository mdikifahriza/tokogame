<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_admin'])) {
    die(json_encode(['success' => false, 'message' => 'Session id_admin tidak ditemukan.']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_game'])) {
        die(json_encode(['success' => false, 'message' => 'ID Game tidak ditemukan.']));
    }

    $id_game = $_POST['id_game'];

    // Cari data game berdasarkan id_game
    $game_sql = "SELECT foto_game FROM game WHERE id_game = ?";
    $game_stmt = $conn->prepare($game_sql);

    if (!$game_stmt) {
        die(json_encode(['success' => false, 'message' => 'Query error: ' . $conn->error]));
    }

    $game_stmt->bind_param("i", $id_game);
    $game_stmt->execute();
    $game_result = $game_stmt->get_result();

    if ($game_result->num_rows > 0) {
        // Hapus file foto jika ditemukan
        while ($game = $game_result->fetch_assoc()) {
            $file_path = "img/game/" . $game['foto_game'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Hapus data game dari database
        $delete_sql = "DELETE FROM game WHERE id_game = ?";
        $delete_stmt = $conn->prepare($delete_sql);

        if (!$delete_stmt) {
            die(json_encode(['success' => false, 'message' => 'Query error: ' . $conn->error]));
        }

        $delete_stmt->bind_param("i", $id_game);
        if ($delete_stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Data game berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data game.']);
        }

        $delete_stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Game tidak ditemukan.']);
    }

    $game_stmt->close();
    $conn->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Metode HTTP tidak valid.']);
exit;
