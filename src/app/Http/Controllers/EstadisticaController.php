<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EstadisticaController extends Controller
{
    public function index()
    {
        // Obtener estadísticas del usuario actual
        $misEstadisticas = DB::table('estadisticas')
            ->where('user_id', Auth::id())
            ->first();

        // Si no hay estadísticas, crear un objeto vacío
        if (!$misEstadisticas) {
            $misEstadisticas = (object)[
                'victorias' => 0,
                'derrotas' => 0,
                'intento_1' => 0,
                'intento_2' => 0,
                'intento_3' => 0,
                'intento_4' => 0,
                'intento_5' => 0
            ];
        }

        // Obtener ranking global ordenado por victorias
        $ranking = DB::table('estadisticas')
            ->join('users', 'estadisticas.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'estadisticas.victorias', 'estadisticas.derrotas')
            ->orderBy('estadisticas.victorias', 'DESC')
            ->orderBy('estadisticas.derrotas', 'ASC')
            ->get();

        // Calcular posición global del usuario actual
        $posicionGlobal = '-';
        foreach ($ranking as $index => $jugador) {
            if ($jugador->id == Auth::id()) {
                $posicionGlobal = $index + 1;
                break;
            }
        }

        return view('estadisticas', compact('misEstadisticas', 'ranking', 'posicionGlobal'));
    }
    public function guardarPartida(Request $request)
    {
        $request->validate([
            'palabra_secreta' => 'required|string',
            'resultado' => 'required|in:ganada,perdida',
            'intentos_usados' => 'required|integer|min:1|max:5'
        ]);

        // Guardar la partida
        DB::table('partidas')->insert([
            'user_id' => Auth::id(),
            'palabra_secreta' => $request->palabra_secreta,
            'resultado' => $request->resultado,
            'intentos_usados' => $request->intentos_usados,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Actualizar estadísticas
        $this->actualizarEstadisticasUsuario($request->resultado, $request->intentos_usados);

        return response()->json(['success' => true]);
    }

    private function actualizarEstadisticasUsuario($resultado, $intentosUsados)
    {
        // Verificar si el usuario ya tiene estadísticas
        $estadisticas = DB::table('estadisticas')
            ->where('user_id', Auth::id())
            ->first();

        if ($estadisticas) {
            // Actualizar estadísticas existentes
            if ($resultado === 'ganada') {
                DB::table('estadisticas')
                    ->where('user_id', Auth::id())
                    ->update([
                        'victorias' => $estadisticas->victorias + 1,
                        'intento_' . $intentosUsados => $estadisticas->{'intento_' . $intentosUsados} + 1,
                        'updated_at' => now()
                    ]);
            } else {
                DB::table('estadisticas')
                    ->where('user_id', Auth::id())
                    ->update([
                        'derrotas' => $estadisticas->derrotas + 1,
                        'updated_at' => now()
                    ]);
            }
        } else {
            // Crear nuevas estadísticas
            $nuevasEstadisticas = [
                'user_id' => Auth::id(),
                'victorias' => 0,
                'derrotas' => 0,
                'intento_1' => 0,
                'intento_2' => 0,
                'intento_3' => 0,
                'intento_4' => 0,
                'intento_5' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];

            if ($resultado === 'ganada') {
                $nuevasEstadisticas['victorias'] = 1;
                $nuevasEstadisticas['intento_' . $intentosUsados] = 1;
            } else {
                $nuevasEstadisticas['derrotas'] = 1;
            }

            DB::table('estadisticas')->insert($nuevasEstadisticas);
        }
    }
}