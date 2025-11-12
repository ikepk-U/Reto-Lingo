<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PalabraController;
use App\Http\Controllers\EstadisticaController;

Route::get('/estadisticas', [EstadisticaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('estadisticas');
    
Route::get('/', function () {
    return view('lingo.welcome');
});

Route::get('/dashboard', function () {
    return view('lingo');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Ruta que devuelve todas las palabras de la tabla 'palabras'
Route::get('/palabras', [PalabraController::class, 'index'])->name('palabras.index');

//Ruta que devuelve todas las palabras de la tabla 'palabras' con estilos css
Route::get('/palabrasStyled', [PalabraController::class, 'indexStyled'])->name('palabras.indexStyled');

//Ruta que devuelve todas las palabras de la tabla 'palabras' con estilos css
Route::get('/palabrasLayout', [PalabraController::class, 'indexLayout'])->name('palabras.indexLayout');;

//Ruta que devuelve de la tabla 'palabras' una palabra aleatoria
//Route::get('/palabrasRandom/', [PalabraController::class, indexRandom'])->name('palabras.indexRandomw');

//Ruta que devuelve de la tabla 'palabras' la cantidad de palabras aleatorias solicitada por URL y sino, devuelve 5 palabras
Route::get('/palabrasRandom/{cantidad?}', [PalabraController::class, 'indexRandom'])->name('palabras.indexRandomw');

//Ruta que devuelve verificar la palabra
Route::get('/verificar-palabra/{palabra}', [PalabraController::class, 'verificarPalabra'])
    ->middleware(['auth', 'verified']) //Te obliga a ver iniciado sesión para poder ver la palabra
    ->name('palabras.verificarPalabra');

//Ruta de Guardar partida
Route::post('/guardar-partida', [EstadisticaController::class, 'guardarPartida'])
    ->middleware(['auth', 'verified'])
    ->name('guardar.partida');

//Ruta de actualizar estadisticas
Route::post('/actualizar-estadisticas', [EstadisticaController::class, 'actualizarEstadisticas'])
    ->middleware(['auth', 'verified'])
    ->name('actualizar.estadisticas');

/* Esto crearia automáticamente todas las rutas para el CRUD
Route::resource('palabras, PalabraController::class);
*/

require __DIR__.'/auth.php';