// ==============================
// VARIABLES GLOBALES DEL JUEGO
// ==============================
let palabraSecreta = "";
const tiempoPorFila = 30;
let filaActual = 0;
let columnaActual = 0;
let timerInterval;
let tiempoRestante = tiempoPorFila;
let juegoTerminado = false;

// ==============================
// FUNCIÓN PARA GUARDAR ESTADÍSTICAS
// ==============================
function guardarEstadisticas(resultado, intentosUsados) {
    fetch('/guardar-partida', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            palabra_secreta: palabraSecreta,
            resultado: resultado,
            intentos_usados: intentosUsados
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Estadísticas guardadas:', data);
    })
    .catch(error => {
        console.error('Error guardando estadísticas:', error);
    });
}

// ==============================
// OBTENER PALABRA ALEATORIA DESDE LA API
// ==============================
async function obtenerPalabraSecreta() {
    try {
        const response = await fetch("http://185.60.43.155:3000/api/word/1");
        
        if (!response.ok) throw new Error("Error al obtener palabra");
        
        const data = await response.json();
        palabraSecreta = data.word.toUpperCase();
        console.log("Palabra secreta:", palabraSecreta);
        iniciarJuego();
        
    } catch (error) {
        console.error("Error cargando palabra:", error);
        palabraSecreta = "CLASE";
        iniciarJuego();
    }
}

// ==============================
// FUNCIÓN PRINCIPAL DEL JUEGO
// ==============================
function iniciarJuego() {
    
    const Letras = [
        ['Q','W','E','R','T','Y','U','I','O','P'],
        ['A','S','D','F','G','H','J','K','L'],
        ['Z','X','C','V','B','N','M']
    ];

    const filasTeclado = document.getElementById("teclado").rows;

    Letras.forEach((letrasFila, indiceFila) => {
        letrasFila.forEach(letter => {
            const td = document.createElement("td");
            td.textContent = letter;
            td.onclick = () => insertarLetra(letter);
            filasTeclado[indiceFila].appendChild(td);
        });
    });

    // BOTÓN ENTER
    const tdEnter = document.createElement("td");
    tdEnter.textContent = "ENTER";
    tdEnter.className = "boton-especial";
    tdEnter.colSpan = 2;
    tdEnter.style.fontSize = "14px";
    tdEnter.onclick = evaluarFila;
    filasTeclado[2].appendChild(tdEnter);

    // BOTÓN BORRAR
    const tdBorrar = document.createElement("td");
    tdBorrar.textContent = "⌫";
    tdBorrar.className = "boton-especial";
    tdBorrar.colSpan = 2;
    tdBorrar.onclick = borrarLetra;
    filasTeclado[2].appendChild(tdBorrar);

    actualizarIndicadorFila();

    function iniciarTemporizador() {
        tiempoRestante = tiempoPorFila;
        actualizarTemporizador();

        clearInterval(timerInterval);
        
        timerInterval = setInterval(() => {
            if (juegoTerminado) {
                clearInterval(timerInterval);
                return;
            }
            
            tiempoRestante--;
            actualizarTemporizador();

            if (tiempoRestante <= 0) {
                clearInterval(timerInterval);
                tiempoAgotado();
            }
        }, 1000);
    }

    function actualizarTemporizador() {
        const temporizador = document.getElementById("temporizador");
        temporizador.textContent = `Tiempo restante: ${tiempoRestante}s`;

        if (tiempoRestante <= 10) {
            temporizador.style.color = "#F95F5F";
        } else {
            temporizador.style.color = "#37382F";
        }
    }

    function tiempoAgotado() {
        columnaActual = 0;
        filaActual++;
        
        if (filaActual >= 5) {
            juegoTerminado = true;
            guardarEstadisticas('perdida', 5); // También cuando se agota el tiempo
            mostrarModalResultado(`Has perdido. La palabra era: ${palabraSecreta}`, "perdedor");
            return;
        }
        
        actualizarIndicadorFila();
        iniciarTemporizador();
    }

    function actualizarIndicadorFila() {
        const indicador = document.getElementById("indicadorFila");
        const table = document.getElementById("lingo");
        
        if (filaActual < 5) {
            const fila = table.rows[filaActual];
            const rect = fila.getBoundingClientRect();
            const tableRect = table.getBoundingClientRect();
            
            indicador.style.top = (rect.top + rect.height / 2 - tableRect.top - 12) + "px";
            indicador.style.display = "block";
        } else {
            indicador.style.display = "none";
        }
    }

    function insertarLetra(letter) {
        if (juegoTerminado) return;
        const table = document.getElementById("lingo");
        if (filaActual >= 5) return;
        if (columnaActual >= 5) return;

        const celda = table.rows[filaActual].cells[columnaActual];
        celda.textContent = letter;
        celda.style.backgroundColor = "#E3E1DA";
        columnaActual++;
    }

    function borrarLetra() {
        if (juegoTerminado) return;
        if (columnaActual <= 0) return;

        columnaActual--;
        const table = document.getElementById("lingo");
        const celda = table.rows[filaActual].cells[columnaActual];
        celda.textContent = "";
        celda.style.backgroundColor = "#E3E1DA";
    }

    function evaluarFila() {
        if (juegoTerminado) return;
        if (columnaActual < 5) return;

        const table = document.getElementById("lingo");
        let palabraFila = "";
        
        for (let i = 0; i < 5; i++) {
            palabraFila += table.rows[filaActual].cells[i].textContent;
        }

        if (palabraFila.length < 5) return;

        const resultado = Array(5).fill("rojo");
        const letrasRestantes = palabraSecreta.split("");

        for (let i = 0; i < 5; i++) {
            if (palabraFila[i] === palabraSecreta[i]) {
                resultado[i] = "verde";
                letrasRestantes[i] = null;
            }
        }

        for (let i = 0; i < 5; i++) {
            if (resultado[i] !== "verde") {
                const index = letrasRestantes.indexOf(palabraFila[i]);
                if (index !== -1) {
                    resultado[i] = "naranja";
                    letrasRestantes[index] = null;
                }
            }
        }

        // === PARTE MODIFICADA ===
        for (let i = 0; i < 5; i++) {
            const celda = table.rows[filaActual].cells[i];
            // Limpiar todas las clases primero
            celda.className = '';
            // Añadir solo la clase del color
            celda.classList.add(resultado[i]);
        }
        // === FIN PARTE MODIFICADA ===

        clearInterval(timerInterval);
        
        columnaActual = 0;
        filaActual++;

        if (palabraFila === palabraSecreta) {
            juegoTerminado = true;
            guardarEstadisticas('ganada', filaActual); // +1 porque filaActual empieza en 0
            mostrarModalResultado("¡Felicidades! Has ganado", "ganador");
            return;
        }

        if (filaActual >= 5) {
            juegoTerminado = true;
            guardarEstadisticas('perdida', 5); // Siempre 5 intentos cuando pierde
            mostrarModalResultado(`Has perdido. La palabra era: ${palabraSecreta}`, "perdedor");
            return;
        }

        actualizarIndicadorFila();
        iniciarTemporizador();
    }
    
    function mostrarModalResultado(mensaje, tipo) {
        const modal = document.createElement("div");
        modal.className = "modal";
        
        const modalContenido = document.createElement("div");
        modalContenido.className = "modal-contenido";
        
        const titulo = document.createElement("h2");
        titulo.textContent = tipo === "ganador" ? "¡Has Ganado!" : "Juego Terminado";
        
        const parrafo = document.createElement("p");
        parrafo.textContent = mensaje;
        
        const btnNuevaPartida = document.createElement("button");
        btnNuevaPartida.textContent = "Nueva Partida";
        btnNuevaPartida.onclick = () => location.reload();
        
        modalContenido.appendChild(titulo);
        modalContenido.appendChild(parrafo);
        modalContenido.appendChild(btnNuevaPartida);
        modal.appendChild(modalContenido);
        
        document.body.appendChild(modal);
    }

    iniciarTemporizador();
}

// Iniciar el juego cuando se cargue la página
document.addEventListener("DOMContentLoaded", () => {
    obtenerPalabraSecreta();
});