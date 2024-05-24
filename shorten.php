<?php
include 'core/db.php';

$secretKey = getenv('RECAPTACHA_KEY');
$token = $_POST['recaptcha_response'];
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$token");
$responseKeys = json_decode($response, true);

if (!$responseKeys["success"] || $responseKeys["score"] < 0.5) {
    echo json_encode(['error' => true, 'message' => 'Error de verificación']);
    exit;
}

header('Content-Type: application/json');
$longUrl = $_POST['long_url'];
$alias = $_POST['alias'];
$authPass = getenv('AUTH_PASS');


if ($_POST['auth_pass'] !== $authPass) {
    echo json_encode(['error' => true, 'message' => 'Contraseña de autorización inválida.']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM urls WHERE short_code = ?");
$stmt->bind_param("s", $alias);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // El alias existe
    echo json_encode(['error' => true, 'message' => 'El alias ya está en uso. Por favor, elige otro.']);
} else {
    // El alias no existe, procede con la inserción o lo que necesites hacer
    // Asegúrate de comprobar si la inserción fue exitosa
    $insertStmt = $conn->prepare("INSERT INTO urls (long_url, short_code) VALUES (?, ?)");
    $insertStmt->bind_param("ss", $longUrl, $alias);
    $success = $insertStmt->execute();
    if ($success) {
        echo json_encode(['error' => false, 'message' => 'Valor introducido correctamente.']);
    } else {
        echo json_encode(['error' => true, 'message' => 'No se pudo guardar el alias.']);
    }
}
