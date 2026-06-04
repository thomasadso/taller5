<?php
// 1. Llamamos a tu archivo de conexión
require_once 'db.php'; 

$mensaje = "";

// 2. Capturamos los datos del formulario cuando se le da a "Registrar"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    
    if (!empty($nombre) && !empty($correo)) {
        // Insertar en PostgreSQL
        try {
            $stmt = $pdo->prepare("INSERT INTO estudiantes (nombre, correo) VALUES (:nombre, :correo)");
            $stmt->execute([':nombre' => $nombre, ':correo' => $correo]);
        } catch (PDOException $e) {
            $mensaje .= "Error PG: " . $e->getMessage() . "<br>";
        }

        // Insertar en MongoDB
        try {
            $mongoCollection->insertOne([
                'nombre' => $nombre,
                'correo' => $correo
            ]);
        } catch (Exception $e) {
            $mensaje .= "Error Mongo: " . $e->getMessage() . "<br>";
        }

        if (empty($mensaje)) {
            $mensaje = "¡Estudiante registrado correctamente en ambas bases de datos!";
        }
    }
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
        
        <!-- Cabecera -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8 border border-slate-200">
            <h1 class="text-3xl font-black text-slate-800">Sistema Académico</h1>
            <p class="text-slate-500">Gestión centralizada: PostgreSQL & MongoDB</p>
        </div>

        <!-- Alerta de éxito o error -->
        <?php if (!empty($mensaje)): ?>
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-8 rounded-r-xl" role="alert">
            <p class="font-bold">Notificación</p>
            <p><?php echo $mensaje; ?></p>
        </div>
        <?php endif; ?>

        <!-- Formulario -->
        <div class="bg-white rounded-3xl shadow-md p-8 mb-8">
            <form action="index.php" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="nombre" placeholder="Nombre completo" required class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-blue-500 transition">
                <input type="email" name="correo" placeholder="Correo electrónico" required class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-blue-500 transition">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition">Registrar</button>
            </form>
        </div>

        <!-- Listados -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Columna PostgreSQL -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 h-96 overflow-y-auto">
                <h2 class="text-lg font-bold text-blue-600 mb-4 uppercase tracking-wider sticky top-0 bg-white pb-2">PostgreSQL</h2>
                <div class="space-y-3">
                    <?php 
                    try {
                        // Consultamos los datos de Postgres
                        $stmt = $pdo->query("SELECT nombre, correo FROM estudiantes ORDER BY id DESC");
                        $hayDatos = false;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $hayDatos = true;
                            echo "<div class='bg-slate-50 p-3 rounded-lg border border-slate-100'>";
                            echo "<p class='font-semibold text-slate-700'>{$row['nombre']}</p>";
                            echo "<p class='text-sm text-slate-500'>{$row['correo']}</p>";
                            echo "</div>";
                        }
                        if (!$hayDatos) {
                            echo "<p class='text-sm text-slate-500 italic'>No hay estudiantes registrados.</p>";
                        }
                    } catch (PDOException $e) {
                        echo "<p class='text-sm text-red-500'>Error al cargar datos.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Columna MongoDB -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 h-96 overflow-y-auto">
                <h2 class="text-lg font-bold text-emerald-600 mb-4 uppercase tracking-wider sticky top-0 bg-white pb-2">MongoDB</h2>
                <div class="space-y-3">
                    <?php 
                    try {
                        // Consultamos los datos de Mongo
                        $cursor = $mongoCollection->find([], ['sort' => ['_id' => -1]]);
                        $hayDatosMongo = false;
                        foreach ($cursor as $doc) {
                            $hayDatosMongo = true;
                            echo "<div class='bg-slate-50 p-3 rounded-lg border border-slate-100'>";
                            echo "<p class='font-semibold text-slate-700'>{$doc['nombre']}</p>";
                            echo "<p class='text-sm text-slate-500'>{$doc['correo']}</p>";
                            echo "</div>";
                        }
                        if (!$hayDatosMongo) {
                            echo "<p class='text-sm text-slate-500 italic'>No hay estudiantes registrados.</p>";
                        }
                    } catch (Exception $e) {
                        echo "<p class='text-sm text-red-500'>Error al cargar datos.</p>";
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</body>
</html>