<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    @if ($feedbackEnviado)
        <h1 style="font-size: 48px; color: #333; text-align: center;">MUCHAS GRACIAS</h1>
    @else
        <div>
            <h3 style="text-align: center; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px;">
                Califica la atención de ventanilla
            </h3>

            <div style="text-align: center; margin-bottom: 20px;">
                <input type="text" wire:model="inputId" placeholder="Ingresa el ID" 
                    style="padding: 10px; font-size: 18px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div class="caras" style="display: flex; justify-content: space-around; align-items: center; gap: 20px;">
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-malo.png') }}" alt="Malo" wire:click="seleccionarPuntuacion(1)" style="cursor: pointer; width: 150px; height: 150px;">
                    <p style="margin-top: 10px; font-size: 18px; color: #333;">Malo</p>
                </div>
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-regular.png') }}" alt="Regular" wire:click="seleccionarPuntuacion(2)" style="cursor: pointer; width: 150px; height: 150px;">
                    <p style="margin-top: 10px; font-size: 18px; color: #333;">Regular</p>
                </div>
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-bueno.png') }}" alt="Bueno" wire:click="seleccionarPuntuacion(3)" style="cursor: pointer; width: 150px; height: 150px;">
                    <p style="margin-top: 10px; font-size: 18px; color: #333;">Bueno</p>
                </div>
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-muy-bueno.png') }}" alt="Muy Bueno" wire:click="seleccionarPuntuacion(4)" style="cursor: pointer; width: 150px; height: 150px;">
                    <p style="margin-top: 10px; font-size: 18px; color: #333;">Muy Bueno</p>
                </div>
                <div style="text-align: center;">
                    <img src="{{ asset('images/cara-excelente.png') }}" alt="Excelente" wire:click="seleccionarPuntuacion(5)" style="cursor: pointer; width: 150px; height: 150px;">
                    <p style="margin-top: 10px; font-size: 18px; color: #333;">Excelente</p>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('recargar-pagina', function () {
            setTimeout(function() {
                location.reload();
            }, 3000); // Recargar la página después de 1.5 segundos
        });
    </script>
</div>
