<x-app-layout>
    <!-- CSS de estadísticas -->
    <link href="{{ asset('css/estadisticas.css') }}" rel="stylesheet">

    <div class="lingo-container">
        <!-- Logo LINGO -->
        <div class="logo-container">
            <img src="{{ asset('images/LogoLingo.png') }}" alt="LINGO">
        </div>

        <h1>ESTADÍSTICAS</h1>

        <div class="contenedor-estadisticas">
            <!-- Mis Estadísticas -->
            <div class="tarjeta tarjeta-grande">
                <h2>
                    MIS ESTADÍSTICAS
                    @if(isset($posicionGlobal))
                    <span class="posicion-global">#{{ $posicionGlobal }} GLOBAL</span>
                    @else
                    <span class="posicion-global">#- GLOBAL</span>
                    @endif
                </h2>
                
                <div class="stats-principales">
                    <div class="victorias">
                        <span class="stat-numero">{{ $misEstadisticas->victorias ?? 0 }}</span>
                        <span class="stat-label">VICTORIAS</span>
                    </div>
                    <div class="derrotas">
                        <span class="stat-numero">{{ $misEstadisticas->derrotas ?? 0 }}</span>
                        <span class="stat-label">DERROTAS</span>
                    </div>
                </div>

                <h3>RÉCORDS POR INTENTO</h3>
                <div class="records">
                    <div class="record-item">
                        <div class="record-intento">Al 1er intento</div>
                        <div class="record-valor">{{ $misEstadisticas->intento_1 ?? 0 }}</div>
                    </div>
                    <div class="record-item">
                        <div class="record-intento">Al 2do intento</div>
                        <div class="record-valor">{{ $misEstadisticas->intento_2 ?? 0 }}</div>
                    </div>
                    <div class="record-item">
                        <div class="record-intento">Al 3er intento</div>
                        <div class="record-valor">{{ $misEstadisticas->intento_3 ?? 0 }}</div>
                    </div>
                    <div class="record-item">
                        <div class="record-intento">Al 4to intento</div>
                        <div class="record-valor">{{ $misEstadisticas->intento_4 ?? 0 }}</div>
                    </div>
                    <div class="record-item">
                        <div class="record-intento">Al 5to intento</div>
                        <div class="record-valor">{{ $misEstadisticas->intento_5 ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <!-- Ranking Global -->
            <div class="tarjeta tarjeta-grande">
                <h2>RANKING GLOBAL</h2>
                
                <table class="tabla-ranking">
                    <thead>
                        <tr>
                            <th class="posicion">#</th>
                            <th>JUGADOR</th>
                            <th>VICTORIAS</th>
                            <th>DERROTAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($ranking) && $ranking->count() > 0)
                            @foreach($ranking as $index => $jugador)
                            <tr class="{{ $jugador->id == Auth::id() ? 'usuario-actual' : '' }}">
                                <td class="posicion">{{ $index + 1 }}</td>
                                <td>
                                    {{ $jugador->name }}
                                    @if($jugador->id == Auth::id())
                                    <span class="indicador-tu">TÚ</span>
                                    @endif
                                </td>
                                <td>{{ $jugador->victorias ?? 0 }}</td>
                                <td>{{ $jugador->derrotas ?? 0 }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px;">
                                    No hay datos de ranking todavía
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Botón volver -->
        <a href="{{ route('dashboard') }}" class="boton-volver">VOLVER AL JUEGO</a>
    </div>

    <style>
        /* MISMO STYLE QUE LINGO.BLADE.PHP */
        /* Reset completo para el contenedor del juego */
        .lingo-container {
            background-color: #F9ECD9 !important;
            margin: 0 !important;
            padding: 0 !important;
            min-height: calc(100vh - 64px) !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: flex-start !important;
            padding-top: 20px !important;
        }

        /* Reset de todos los contenedores de Laravel */
        .min-h-screen { 
            min-height: 0 !important; 
            background-color: #F9ECD9 !important;
            overflow: hidden !important;
        }
        .bg-gray-100 { background-color: #F9ECD9 !important; }
        .py-6 { padding: 0 !important; }
        .max-w-7xl { max-width: none !important; margin: 0 auto !important; }
        .mx-auto { margin: 0 !important; }
        .sm\:px-6, .lg\:px-8 { padding: 0 !important; }
        main { 
            padding: 0 !important; 
            margin: 0 !important; 
            background: #F9ECD9 !important;
            min-height: calc(100vh - 64px) !important;
            overflow: hidden !important;
        }

        /* Centrar la barra de navegación */
        .flex.justify-between {
            justify-content: center !important;
            gap: 40px;
        }

        /* Logo más pequeño */
        .shrink-0 img {
            max-height: 35px !important;
        }
    </style>
</x-app-layout>