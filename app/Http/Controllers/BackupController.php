<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function getBackup()
    {
        return view('backup');
    }
    public function createBackup()
    {
        // Ejecutar el comando de respaldo usando Artisan
        Artisan::call('backup:run');

        // Obtener el archivo de respaldo más reciente en la carpeta "storage/app/Laravel"
        $files = Storage::disk('local')->files('Laravel');

        // Asegurarse de que hay al menos un archivo de respaldo
        if (empty($files)) {
            return response()->json(['error' => 'No se encontró ningún archivo de respaldo.'], 404);
        }

        // Obtener el archivo más reciente
        $lastBackupFile = collect($files)->last();

        // Ruta completa del archivo
        $filePath = storage_path('app/Laravel/' . $lastBackupFile);

        // Descargar el archivo, corregir si ya existe el archivo
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'El archivo de respaldo no se encuentra.'], 404);
        }

        // Descargar el archivo
        return response()->download($filePath);
    }
}
