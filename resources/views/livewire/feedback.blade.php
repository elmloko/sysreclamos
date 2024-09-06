<div style="display: flex; justify-content: center; align-items: center; height: 100vh; padding: 20px;">
    @if ($feedbackEnviado)
        <h1 style="font-size: 6vw; color: #333; text-align: center;">MUCHAS GRACIAS</h1>
    @else
        <div>
            <h3 style="text-align: center; font-size: 4.5vw; font-weight: bold; color: #333; margin-bottom: 20px;">
                Califica la atención de ventanilla
            </h3>

            @if ($mensaje)
                <p style="text-align: center; color: red; font-size: 3.5vw;">{{ $mensaje }}</p>
            @endif

            <div style="text-align: center; margin-bottom: 20px;">
                <input type="text" wire:model="inputId" placeholder="Ingresa el ID" 
                    style="padding: 10px; font-size: 3.5vw; border: 1px solid #ccc; border-radius: 4px; width: 100%; max-width: 400px;"
                    id="inputId" autocomplete="off">
            </div>

            <div class="caras" style="display: flex; justify-content: space-around; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-malo.png') }}" alt="Malo" wire:click="seleccionarPuntuacion(1)" 
                         style="cursor: pointer; width: 18vw; height: 18vw; max-width: 200px; max-height: 200px;">
                    <p style="margin-top: 10px; font-size: 3.5vw; color: #333;">Malo</p>
                </div><br>
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-regular.png') }}" alt="Regular" wire:click="seleccionarPuntuacion(2)" 
                         style="cursor: pointer; width: 18vw; height: 18vw; max-width: 200px; max-height: 200px;">
                    <p style="margin-top: 10px; font-size: 3.5vw; color: #333;">Regular</p>
                </div><br>
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-bueno.png') }}" alt="Bueno" wire:click="seleccionarPuntuacion(3)" 
                         style="cursor: pointer; width: 18vw; height: 18vw; max-width: 200px; max-height: 200px;">
                    <p style="margin-top: 10px; font-size: 3.5vw; color: #333;">Bueno</p>
                </div><br>
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-muy-bueno.png') }}" alt="Muy Bueno" wire:click="seleccionarPuntuacion(4)" 
                         style="cursor: pointer; width: 18vw; height: 18vw; max-width: 200px; max-height: 200px;">
                    <p style="margin-top: 10px; font-size: 3.5vw; color: #333;">Muy Bueno</p>
                </div><br>
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-excelente.png') }}" alt="Excelente" wire:click="seleccionarPuntuacion(5)" 
                         style="cursor: pointer; width: 18vw; height: 18vw; max-width: 200px; max-height: 200px;">
                    <p style="margin-top: 10px; font-size: 3.5vw; color: #333;">Excelente</p>
                </div><br>
            </div>
            
            <div style="text-align: center; margin-top: 20px;" id="contador-container" hidden>
                <h2 id="contador" style="font-size: 4.5vw; color: #ff0000;">3.0</h2>
                <p style="font-size: 3.5vw; color: #333;">Tiempo restante antes de que la calificación se asigne automáticamente.</p>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let tiempoRestante = 180; // 3 minutos en segundos
            const contadorElemento = document.getElementById('contador');
            const contadorContainer = document.getElementById('contador-container');
            let interval;

            document.getElementById('inputId').addEventListener('input', function() {
                if (this.value.length > 0) {
                    clearInterval(interval);
                    tiempoRestante = 180; // Reiniciar el tiempo
                    contadorContainer.hidden = false; // Mostrar el contador

                    interval = setInterval(function() {
                        tiempoRestante -= 1;
                        let segundos = (tiempoRestante / 60).toFixed(1);
                        contadorElemento.textContent = segundos;

                        if (tiempoRestante <= 0) {
                            clearInterval(interval);
                            @this.call('asignarPuntuacionAutomatica');
                        }
                    }, 1000);
                }
            });
        });

        document.addEventListener('recargar-pagina', function () {
            setTimeout(function() {
                location.reload();
            }, 3000); // Recargar la página después de 3 segundos
        });
    </script>
</div>
