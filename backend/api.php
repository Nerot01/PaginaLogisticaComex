<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

// Funciones auxiliares
function checkAuth()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'No autorizado']);
        exit;
    }
}

$method = $_SERVER['REQUEST_METHOD'];
$type = $_GET['type'] ?? ''; // 'activities', 'resources'

if ($method === 'GET') {
    if ($type === 'activities') {
        $stmt = $pdo->query("SELECT * FROM activities ORDER BY date_event DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } elseif ($type === 'resources') {
        $category = $_GET['category'] ?? '';
        $sql = "SELECT * FROM resources";
        if ($category) {
            $sql .= " WHERE category = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$category]);
        } else {
            $stmt = $pdo->query($sql);
        }
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
} elseif ($method === 'POST') {
    checkAuth();
    $data = json_decode(file_get_contents('php://input'), true);

    if ($type === 'activities') {
        $sql = "INSERT INTO activities (title, description, date_event, location, media_url, media_type) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['date_event'],
            $data['location'],
            $data['media_url'],
            $data['media_type']
        ]);
        echo json_encode(['success' => true]);
    } elseif ($type === 'resources') {
        $sql = "INSERT INTO resources (title, description, file_url, category) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['file_url'],
            $data['category']
        ]);
        echo json_encode(['success' => true]);
    }
} elseif ($method === 'DELETE') {
    checkAuth();
    $id = $_GET['id'] ?? 0;
    if ($type === 'activities') {
        $stmt = $pdo->prepare("DELETE FROM activities WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
    } elseif ($type === 'resources') {
        $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
    }
}
?>