<?php
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validaciones
    if (empty($data['nombre']) || empty($data['correo'])) {
        echo json_encode(['status' => 'error', 'msg' => 'Datos incompletos']);
        exit;
    }

    try {
        // Postgres
    $stmt = $pdo->prepare("INSERT INTO estudiantes (nombre, correo, fecha) VALUES (?, ?, CURRENT_TIMESTAMP)");
    $stmt->execute([$data['nombre'], $data['correo']]);
        
        // Mongo
        $mongoCollection->insertOne([
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'fecha' => new MongoDB\BSON\UTCDateTime()
        ]);
        
        echo json_encode(['status' => 'success', 'msg' => 'Estudiante registrado']);
    } catch (Exception $e) {
    echo json_encode(['status' => 'error', 'msg' => 'Error: ' . $e->getMessage()]);
}
}
?>