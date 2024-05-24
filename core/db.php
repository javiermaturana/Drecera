<?php
$servername = "localhost";
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');
$dbName = getenv('DB_NAME');

// Crear conexión
$conn = new mysqli($servername, $dbUser, $dbPass, $dbName);
?>