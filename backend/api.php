<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

// Funciones auxiliares
function checkAuth()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
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
    $input = json_decode(file_get_contents('php://input'), true);

    if ($type === 'activities') {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $date_event = $_POST['date_event'] ?? '';
        $location = $_POST['location'] ?? '';
        $media_type = $_POST['media_type'] ?? null;
        $media_url = null;

        // Procesar subida de imagen
        if ($media_type === 'image' && isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            
            $fileName = uniqid() . '_' . basename($_FILES['media_file']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['media_file']['tmp_name'], $targetPath)) {
                $media_url = 'uploads/' . $fileName; // Ruta relativa para guardar en BD
            }
        }

        $id = $_POST['id'] ?? null;

        if ($id) {
            // UPDATE via POST
            $sql = "UPDATE activities SET title=?, description=?, date_event=?, location=?, media_url=?, media_type=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $description, $date_event, $location, $media_url, $media_type, $id]);
        } else {
            // INSERT
        http_response_code(400);
        echo json_encode(['error' => 'ID no proporcionado']);
        exit;
    }

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