<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DetalleMaterial;

class BusquedaAvanzadaController extends Controller
{
    public function buscar(Request $request)
    {
        $criterio = $request->input('criterio');
        $valorCriterio = $request->input('valor_criterio');
        $titulo = $request->input('titulo');
        $orden = $request->input('orden', 'asc');
    
        $query = DB::table('DETALLE_MATERIAL')->distinct();
    
        if ($criterio === 'autor' && $valorCriterio) {
            $query->select('DSM_AUTOR_EDITOR as autor')
                  ->where('DSM_AUTOR_EDITOR', 'LIKE', "%{$valorCriterio}%")
                  ->orderBy('DSM_AUTOR_EDITOR', $orden);
        } elseif ($criterio === 'editorial' && $valorCriterio) {
            $query->select('DSM_EDITORIAL as editorial')
                  ->where('DSM_EDITORIAL', 'LIKE', "%{$valorCriterio}%")
                  ->orderBy('DSM_EDITORIAL', $orden);
        }
    
        if ($titulo) {
            $query->where('DSM_TITULO', 'LIKE', "%{$titulo}%");
        }
    
        $resultados = $query->get();
    
        return view('BusquedaAvanzadaResultados', compact('resultados', 'criterio', 'valorCriterio', 'titulo', 'orden'));
    }
    

    public function mostrarTitulosPorAutor($autor, Request $request)
    {
        $titulo = $request->input('titulo');

        $query = DetalleMaterial::query()
            ->select('DSM_TITULO')
            ->where('DSM_AUTOR_EDITOR', '=', urldecode($autor));

        if ($titulo) {
            $query->where('DSM_TITULO', 'LIKE', '%' . $titulo . '%');
        }

        $titulos = $query->get();

        return view('TitulosPorAutor', compact('autor', 'titulos', 'titulo'));
    }
    public function mostrarTitulosPorEditorial($editorial, Request $request)
    {
        $titulo = $request->input('titulo');

        $query = DetalleMaterial::query()
            ->select('DSM_TITULO')
            ->where('DSM_EDITORIAL', '=', urldecode($editorial));

        if ($titulo) {
            $query->where('DSM_TITULO', 'LIKE', '%' . $titulo . '%');
        }

        $titulos = $query->get();

        return view('TitulosPorEditorial', compact('editorial', 'titulos', 'titulo'));
    }
}
