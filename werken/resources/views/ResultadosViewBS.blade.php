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
        <form method="GET" id="form-busqueda" class="mb-6">
            <div class="mb-4">
                <label for="criterio" class="block text-sm font-medium text-gray-700">Seleccione un criterio:</label>
                <select id="criterio" name="criterio" class="form-select mt-1 block w-full" onchange="updateFormAction()">
                    <option value="autor" {{ request('criterio') === 'autor' ? 'selected' : '' }}>Autor</option>
                    <option value="editorial" {{ request('criterio') === 'editorial' ? 'selected' : '' }}>Editorial</option>
                    <option value="serie" {{ request('criterio') === 'serie' ? 'selected' : '' }}>Serie</option>
                    <option value="materia" {{ request('criterio') === 'materia' ? 'selected' : '' }}>Materia</option>
                    <option value="titulo" {{ request('criterio') === 'titulo' ? 'selected' : '' }}>Título</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="busqueda" class="block text-sm font-medium text-gray-700">Ingrese el término:</label>
                <input type="text" id="busqueda" name="busqueda" class="form-input mt-1 block w-full" value="{{ request('busqueda') }}" required>
            </div>

            <button type="submit" class="bg-blue-800 text-white px-4 py-2 rounded">Buscar</button>
        </form>

        @if($resultados->isEmpty())
            <p class="text-red-500">No se encontraron resultados.</p>
        @else
            <ul class="pl-5">
                @foreach($resultados as $resultado)
                    <li>
                        <span class="font-bold">{{ $loop->iteration }}.</span>
                        <a href="{{ route('recursos.asociados', ['criterio' => $criterio, 'valor' => $resultado->nombre_busqueda]) }}" 
                        class="text-blue-500 underline">
                        {{ $resultado->nombre_busqueda }}
                        </a>
                    </li>
                @endforeach
            </ul>
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

<script>
    function updateFormAction() {
        const criterio = document.getElementById('criterio').value;
        const form = document.getElementById('form-busqueda');

        if (criterio === 'titulo') {
            form.action = "{{ route('buscar.titulo') }}";
        } else {
            form.action = "{{ route('resultados') }}";
        }
    }
    document.addEventListener('DOMContentLoaded', updateFormAction);
</script>
