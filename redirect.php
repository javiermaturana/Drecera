<?php
include 'core/db.php';

$alias = $_GET['alias'];

// Buscar el alias en la base de datos
$stmt = $conn->prepare("SELECT long_url FROM urls WHERE short_code = ?");
$stmt->bind_param("s", $alias);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Location: " . $row['long_url']);
    exit();
} else {
    // Redireccionar a una página de error 404 personalizada
    header("HTTP/1.1 404 Not Found");
    include('404.html'); // Asegúrate de que el archivo 404.html exista en tu servidor
    exit();
}
?>
