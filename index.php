<?php 
// Incluimos la conexión para poder consultar las bases de datos
require_once 'db.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sistema Académico</title>
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Sistema Académico</h1>
        
        <form id="registroForm" class="bg-white p-6 rounded-xl shadow mb-8">
            <input type="text" id="nombre" class="border p-2 w-full mb-2" placeholder="Nombre" required>
            <input type="email" id="correo" class="border p-2 w-full mb-4" placeholder="Correo" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Registrar</button>
        </form>

        <div id="status" class="mb-4"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-blue-600 mb-4">PostgreSQL</h2>
                <?php
                // Consultamos con la columna 'fecha' que ya agregaste en DBeaver
                $stmt = $pdo->query("SELECT nombre, correo, fecha FROM estudiantes ORDER BY id DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='border-b py-2'>";
                    echo "<p class='font-semibold'>{$row['nombre']}</p>";
                    echo "<p class='text-sm text-gray-500'>{$row['correo']}</p>";
                    echo "<p class='text-xs text-gray-400'>Registrado: {$row['fecha']}</p>";
                    echo "</div>";
                }
                ?>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-emerald-600 mb-4">MongoDB</h2>
                <?php
                $cursor = $mongoCollection->find([], ['sort' => ['_id' => -1]]);
                foreach ($cursor as $doc) {
                    echo "<div class='border-b py-2'>";
                    echo "<p class='font-semibold'>{$doc['nombre']}</p>";
                    echo "<p class='text-sm text-gray-500'>{$doc['correo']}</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registroForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const res = await fetch('api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    nombre: document.getElementById('nombre').value,
                    correo: document.getElementById('correo').value
                })
            });
            const result = await res.json();
            document.getElementById('status').innerText = result.msg;
            if(result.status === 'success') location.reload();
        });
    </script>
</body>
</html>