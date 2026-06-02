<?php
require 'vendor/autoload.php'; // Carga Composer

// CONEXIÓN POSTGRESQL (PDO)
$pg_url = "postgresql://registro_estudiantes_user:PVlxDGwqF8Pt6hm9d9KzT9C0iIndg5Xz@dpg-d8f29e6gvqtc738qnl1g-a.ohio-postgres.render.com/registro_estudiantes";
try {
    $pdo = new PDO($pg_url);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Crea la tabla si no existe
    $pdo->exec("CREATE TABLE IF NOT EXISTS estudiantes (id SERIAL PRIMARY KEY, nombre VARCHAR(100), correo VARCHAR(100))");
} catch (PDOException $e) {
    die("Error PostgreSQL: " . $e->getMessage());
}

// CONEXIÓN MONGODB
$mongo_uri = "mongodb+srv://tccpcsf_db_user:taller5@clusterpractica1mongo.o08m1ks.mongodb.net/?appName=CLUSTERPRACTICA1MONGO";
try {
    $mongoClient = new MongoDB\Client($mongo_uri);
    $mongoCollection = $mongoClient->universidad->estudiantes; // BD: universidad, Colección: estudiantes
} catch (Exception $e) {
    die("Error MongoDB: " . $e->getMessage());
}
?>