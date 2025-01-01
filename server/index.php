<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit(0);
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_NAME');
$port = getenv('DB_PORT');

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS email_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            recipient VARCHAR(255) NOT NULL,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
} catch (PDOException $e) {
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query('SELECT "Hello from the database" AS msg');
        $row = $stmt->fetch();
        echo json_encode(["message" => $row['msg']]);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = 'test@example.com';
    $subject = 'Hello from container';
    $message = 'This is a test email.';
    $headers = 'From: dev@example.com';

    try {
        $stmt = $pdo->prepare("INSERT INTO email_logs (recipient) VALUES (:recipient)");
        $stmt->execute(['recipient' => $to]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Failed to log email: " . $e->getMessage()]);
        exit;
    }

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(["status" => "Email sent"]);
    } else {
        echo json_encode(["status" => "Failed to send email"]);
    }
}
