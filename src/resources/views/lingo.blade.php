<x-app-layout>
    <!-- CSS del juego -->
    <link href="{{ asset('css/lingo.css') }}" rel="stylesheet">

    <div class="lingo-container">
        <!-- Logo LINGO -->
        <div class="logo-container">
            <img src="{{ asset('images/LogoLingo.png') }}" alt="LINGO" id="logoLingo">
        </div>

        <!-- Contenedor principal -->
        <div class="contenedor-principal">
            <!-- Contenedor del tablero con indicador -->
            <div class="contenedor-tablero">
                <div class="indicador-fila" id="indicadorFila">></div>
                
                <!-- Tabla principal 5x5 -->
                <table id="lingo">
                    <tbody>
                        <tr><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Temporizador -->
            <div id="temporizador">Tiempo restante: 30s</div>

            <!-- Teclado -->
            <table class="teclado" id="teclado">
                <tbody>
                    <tr></tr>
                    <tr></tr>
                    <tr></tr>
                </tbody>
            </table>
        </div>

        <!-- Área para mensajes -->
        <div id="mensajes" style="display: none;"></div>
    </div>

    <!-- JS del juego -->
    <script src="{{ asset('js/lingo.js') }}"></script>

<style>
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