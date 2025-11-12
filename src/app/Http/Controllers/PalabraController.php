<?php

namespace App\Http\Controllers;

use App\Models\Palabra;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PalabraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $palabras = Palabra::all();
        return view('palabras.index', ['palabras' => $palabras]);
    }

    public function indexStyled() {
        $palabras = Palabra::all();
        return view('palabras.indexStyled', ['palabras' => $palabras]);
    }

    public function indexLayout() {
        $palabras = Palabra::all();
        return view('palabras.indexLayout', ['palabras' => $palabras]);
    }

    public function indexRandom($cantidad = 1)
    {
        $palabras = Palabra::inRandomOrder()->take($cantidad)->get();
        
        return view('palabras.index', ['palabras' => $palabras]);
    }

    // NUEVO MÉTODO - VERIFICAR PALABRA
    /**
     * Verifica si una palabra existe en la base de datos.
     *
     * @param string $palabra El parámetro recibido desde la URL.
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarPalabra(string $palabra): JsonResponse
    {
        $existe = Palabra::where('palabra', $palabra)->exists();

        // Si quisieras devolver JSON
        return response()->json([
            'palabra_buscada' => $palabra,
            'existe' => $existe
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Palabra $palabra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Palabra $palabra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Palabra $palabra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Palabra $palabra)
    {
        //
    }
}
