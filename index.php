<?php 
// Incluimos la conexión centralizada
require_once 'db.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sistema Académico</title>
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-slate-800">Sistema Académico</h1>
        
        <form id="registroForm" class="bg-white p-6 rounded-xl shadow mb-8">
            <input type="text" id="nombre" class="border p-2 w-full mb-2 rounded" placeholder="Nombre completo" required>
            <input type="email" id="correo" class="border p-2 w-full mb-4 rounded" placeholder="Correo electrónico" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">Registrar</button>
        </form>

        <div id="status" class="mb-4 text-center font-medium"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-white p-6 rounded-xl shadow border border-slate-100">
                <h2 class="font-bold text-blue-600 mb-4 border-b pb-2">POSTGRESQL</h2>
                <?php
                try {
                    $stmt = $pdo->query("SELECT nombre, correo, fecha FROM estudiantes ORDER BY id DESC");
                    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (empty($registros)) {
                        echo "<p class='text-sm text-gray-400'>No hay registros.</p>";
                    } else {
                        foreach ($registros as $row) {
                            echo "<div class='border-b py-3'>";
                            echo "<p class='font-semibold text-slate-800'>".htmlspecialchars($row['nombre'])."</p>";
                            echo "<p class='text-sm text-slate-500'>".htmlspecialchars($row['correo'])."</p>";
                            echo "<p class='text-[10px] text-gray-400 mt-1 uppercase'>Registrado: {$row['fecha']}</p>";
                            echo "</div>";
                        }
                    }
                } catch (PDOException $e) {
                    echo "<p class='text-red-500 text-sm'>Error: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>

            <div class="bg-white p-6 rounded-xl shadow border border-slate-100">
                <h2 class="font-bold text-emerald-600 mb-4 border-b pb-2">MONGODB</h2>
                <?php
                try {
                    $cursor = $mongoCollection->find([], ['sort' => ['_id' => -1]]);
                    $hayMongo = false;
                    foreach ($cursor as $doc) {
                        $hayMongo = true;
                        echo "<div class='border-b py-3'>";
                        echo "<p class='font-semibold text-slate-800'>".htmlspecialchars($doc['nombre'])."</p>";
                        echo "<p class='text-sm text-slate-500'>".htmlspecialchars($doc['correo'])."</p>";
                        echo "</div>";
                    }
                    if (!$hayMongo) echo "<p class='text-sm text-gray-400'>No hay registros.</p>";
                } catch (Exception $e) {
                    echo "<p class='text-red-500 text-sm'>Error: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registroForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            btn.disabled = true;
            btn.innerText = 'Procesando...';

            const res = await fetch('api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    nombre: document.getElementById('nombre').value,
                    correo: document.getElementById('correo').value
                })
            });
            
            const result = await res.json();
            const statusDiv = document.getElementById('status');
            statusDiv.innerText = result.msg;
            statusDiv.className = result.status === 'success' ? 'text-green-600 mb-4' : 'text-red-600 mb-4';
            
            if(result.status === 'success') {
                setTimeout(() => location.reload(), 1000);
            } else {
                btn.disabled = false;
                btn.innerText = 'Registrar';
            }
        });
    </script>
</body>
</html>