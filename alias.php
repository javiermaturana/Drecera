<?php
include 'core/db.php';

$stmt = $conn->prepare("SELECT short_code, long_url FROM urls");
$stmt->execute();
$result = $stmt->get_result();

$aliases = [];
while ($row = $result->fetch_assoc()) {
    $aliases[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Acortador de URL">
    <meta name="keywords" content="acortador de URL, URL corta, acortar enlace">
    <title>Lista de Alias</title>
    <link rel="icon" href="../img/favicon.ico" sizes="any">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            background-image: radial-gradient(ellipse 80% 80% at 50% -20%, #7877c64d, #fff0);
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m8 l6 offset-m2 offset-l3">
                <h1>Lista de Alias 🔗</h1>
                <ul class="collection">
                    <?php foreach ($aliases as $alias): ?>
                        <li class="collection-item">
                            <a href="<?php echo htmlspecialchars($alias['long_url']); ?>" target="_blank">
                                <?php echo htmlspecialchars($alias['short_code']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>