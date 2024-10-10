<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Http;

class FormPublic extends Component
{
    public $fullName;
    public $address;
    public $country;
    public $identityCard;
    public $codepostal;
    public $email;
    public $phone;
    public $description;
    public $recaptcha;

    protected $rules = [
        'fullName' => 'required|string|max:50',
        'country' => 'required|string|max:50',
        'email' => 'required|email|max:50',
        'phone' => 'required|integer',
        'identityCard' => 'required|integer',
        'description' => 'required|nullable|string',
        'recaptcha' => 'required',
    ];

    public function submit()
    {
        $this->validate(); // Valida todos los campos incluidos los del reCAPTCHA

        // Verificar reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6LdIqDcqAAAAAMb08_WCzPXCPDINC_aNSsCPgiH0', // Reemplaza con tu clave secreta
            'response' => $this->recaptcha, // Utiliza la propiedad Livewire recaptcha
        ]);

        $responseBody = json_decode($response->body());

        if (!$responseBody->success) {
            session()->flash('message', 'Por favor, verifica que no eres un robot.');
            return;
        }

        // Continuar con el envío del formulario si el captcha es válido
        $this->validate();

        // Obtener el último correlativo y crear el nuevo registro
        $lastRecord = Suggestion::where('correlativo', 'like', 'SGR%')
            ->orderBy('correlativo', 'desc')
            ->first();

        if ($lastRecord) {
            $lastNumber = (int)substr($lastRecord->correlativo, 3);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $newCorrelativo = 'SGR' . $newNumber;

        Suggestion::create([
            'fullName' => strtoupper($this->fullName),
            'address' => strtoupper($this->address),
            'country' => strtoupper($this->country),
            'codepostal' => strtoupper($this->codepostal),
            'email' => $this->email,
            'phone' => strtoupper($this->phone),
            'identityCard' => strtoupper($this->identityCard),
            'description' => strtoupper($this->description),
            'correlativo' => $newCorrelativo,
            'estado' => 'PUBLICADO',
        ]);

        session()->flash('message', 'Reclamación enviada con éxito');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.form-public');
    }
}
