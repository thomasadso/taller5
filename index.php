<?php
// Configuración básica para evitar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Si tienes un archivo db.php, descomenta la línea de abajo:
// require_once 'db.php'; 

// --- LÓGICA DE REGISTRO (POST) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    
    // Aquí iría tu lógica de inserción en Postgres y Mongo
    // Ejemplo: $pdo->prepare("INSERT INTO...") o $collection->insertOne(...)
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Académico</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8 border border-slate-200">
            <h1 class="text-3xl font-black text-slate-800">Sistema Académico</h1>
            <p class="text-slate-500">Gestión centralizada: PostgreSQL & MongoDB</p>
        </div>

        <div class="bg-white rounded-3xl shadow-md p-8 mb-8">
            <form action="" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="nombre" placeholder="Nombre completo" required class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none">
                <input type="email" name="correo" placeholder="Correo electrónico" required class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition">Registrar</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-blue-600 mb-4 uppercase">PostgreSQL</h2>
                <div class="space-y-2">
                    <?php 
                    // COPIA AQUÍ TU BUCLE PHP DE POSTGRES
                    echo "<p class='text-sm text-slate-500'>Listado cargando...</p>";
                    ?>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-emerald-600 mb-4 uppercase">MongoDB</h2>
                <div class="space-y-2">
                    <?php 
                    // COPIA AQUÍ TU BUCLE PHP DE MONGO
                    echo "<p class='text-sm text-slate-500'>Listado cargando...</p>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>