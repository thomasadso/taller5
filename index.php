<?php
// Incluye aquí tu archivo de conexión o lógica de base de datos (db.php)
// require_once 'db.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Gestión Estudiantil</title>
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
                <input type="text" name="nombre" placeholder="Nombre completo" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                <input type="email" name="correo" placeholder="Correo electrónico" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-blue-200">Registrar Estudiante</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-blue-600 mb-4 uppercase tracking-wider">PostgreSQL</h2>
                <div class="space-y-3">
                    <p class="text-slate-400 text-sm italic">Esperando datos...</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-emerald-600 mb-4 uppercase tracking-wider">MongoDB</h2>
                <div class="space-y-3">
                    <p class="text-slate-400 text-sm italic">Esperando datos...</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>