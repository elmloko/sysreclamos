<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div>
        <h3 style="text-align: center; font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px;">
            Califica la atención de ventanilla
        </h3>
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

        <div style="text-align: center; margin-top: 20px;">
            <button wire:click="guardarFeedback" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                Enviar Feedback
            </button>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success" style="text-align: center; margin-top: 20px;">
                {{ session('message') }}
            </div>
        @endif
    </div>
</div>
