<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la Búsqueda</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Resultados de la Búsqueda</h1>

        <!-- Formulario de Búsqueda -->
        <form id="form-busqueda" method="GET" action="{{ route('resultados') }}" class="mb-6">
            <div class="mb-4">
                <label for="criterio" class="block text-sm font-medium text-gray-700">Seleccione un criterio:</label>
                <select id="criterio" name="criterio" class="form-select mt-1 block w-full">
                    <option value="autor" {{ $criterio === 'autor' ? 'selected' : '' }}>Autor</option>
                    <option value="editorial" {{ $criterio === 'editorial' ? 'selected' : '' }}>Editorial</option>
                    <option value="serie" {{ $criterio === 'serie' ? 'selected' : '' }}>Serie</option>
                    <option value="materia" {{ $criterio === 'materia' ? 'selected' : '' }}>Materia</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="busqueda" class="block text-sm font-medium text-gray-700">Ingrese el término:</label>
                <input type="text" id="busqueda" name="busqueda" class="form-input mt-1 block w-full" value="{{ $busqueda }}" required>
            </div>
            <button type="submit" class="bg-blue-800 text-white px-4 py-2 rounded">Buscar</button>
        </form>

        <!-- Resultados de la búsqueda -->
        @if($resultados->isEmpty())
            <p class="text-red-500">No se encontraron resultados.</p>
        @else
            <ul class="list-disc pl-5">
                @foreach($resultados as $resultado)
                    <li>
                        <a href="{{ route('recursos.asociados', ['criterio' => $criterio, 'valor' => $resultado['nombre']]) }}" 
                        class="text-blue-500 underline">
                            {{ $resultado['nombre'] }}
                        </a>
                        <ul class="pl-5">
                            @foreach($resultado['titulos'] as $titulo)
                                <li>{{ $titulo }}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            <!-- Navegación de Paginación -->
            <div class="mt-4">
                {{ $resultados->links() }}
            </div>
        @endif

        <div class="mt-4">
            <a href="/" class="text-blue-500 underline">Volver a la página principal</a>
        </div>
    </div>
</body>
</html>
