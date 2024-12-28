<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda Avanzada</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Contenedor principal -->
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Búsqueda Avanzada</h1>

        <form action="/busqueda-avanzada" method="GET" class="space-y-4">
            <div>
                <label for="autor" class="block font-bold">Autor:</label>
                <input type="text" id="autor" name="autor" class="border-gray-300 rounded-md w-full p-2">
            </div>
            <div>
                <label for="titulo" class="block font-bold">Título:</label>
                <input type="text" id="titulo" name="titulo" class="border-gray-300 rounded-md w-full p-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white rounded-md px-4 py-2">Buscar</button>
        </form>

        <a href="/" class="mt-4 text-blue-500 hover:underline block">Volver a la página principal</a>
    </div>

</body>
</html>
