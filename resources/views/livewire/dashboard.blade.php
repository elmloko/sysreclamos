<div style="max-width: 800px; margin: 20px auto; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <input 
            type="text" 
            wire:model="codigo" 
            placeholder="Ingresa el código"
            style="flex: 1; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; margin-right: 10px;"
        >
        <button 
            wire:click="search" 
            style="padding: 10px 15px; font-size: 16px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;"
        >
            Buscar
        </button>
    </div>

    @if(!empty($codigo) && !empty($events))
        <h2 style="text-align: center; margin-bottom: 15px;">Eventos del código: {{ $codigo }}</h2>
    @endif

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #007bff; color: #fff;">
                <th style="padding: 10px; text-align: left;">Acción</th>
                <th style="padding: 10px; text-align: left;">Descripción</th>
                <th style="padding: 10px; text-align: left;">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($this->events as $event)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">{{ $event['eventType'] ?? $event['action'] }}</td>
                    <td style="padding: 10px;">{{ $event['condition'] ?? $event['descripcion'] }}</td>
                    <td style="padding: 10px;">{{ $event['eventDate'] ?? $event['updated_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
