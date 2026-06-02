<?php
require 'db.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    try {
        // 1. Insertar en PostgreSQL
        $stmt = $pdo->prepare("INSERT INTO estudiantes (nombre, correo) VALUES (?, ?)");
        $stmt->execute([$nombre, $correo]);
        
        // 2. Insertar en MongoDB
        $resultadoMongo = $mongoCollection->insertOne(['nombre' => $nombre, 'correo' => $correo]);
        
        if($resultadoMongo->getInsertedCount() > 0) {
            $mensaje = "<div style='color:green;'>¡Estudiante $nombre registrado correctamente en PostgreSQL y MongoDB!</div>";
        }
    } catch (Exception $e) {
        $mensaje = "<div style='color:red;'>Error al registrar: " . $e->getMessage() . "</div>";
    }
}

// Consultar listas
$listaPg = $pdo->query("SELECT * FROM estudiantes")->fetchAll(PDO::FETCH_ASSOC);
$listaMongo = $mongoCollection->find()->toArray();
?>

<h2>Registro de Estudiantes</h2>
<?= $mensaje ?>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre completo" required>
    <input type="email" name="correo" placeholder="Correo" required>
    <button type="submit">Registrar</button>
</form>

<hr>

<h3>Listado PostgreSQL</h3>
<ul>
    <?php foreach($listaPg as $est) echo "<li>{$est['nombre']} - {$est['correo']}</li>"; ?>
</ul>

<h3>Listado MongoDB</h3>
<ul>
    <?php foreach($listaMongo as $est) echo "<li>{$est['nombre']} - {$est['correo']}</li>"; ?>
</ul>