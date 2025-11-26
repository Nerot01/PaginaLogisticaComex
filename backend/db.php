<?php
// Cargar configuración si existe, sino usar valores por defecto (o vacíos)
if (file_exists(__DIR__ . '/config.php')) {
    require __DIR__ . '/config.php';
} else {
    // Valores por defecto o variables de entorno para producción si se prefiere
    $host = 'localhost';
    $dbname = 'nombre_base_datos';
    $username = 'usuario_base_datos';
    $password = 'contraseña_base_datos';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>