<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GasLog;
use App\Models\TemperatureLog;

class SensorController extends Controller
{
    // Fungsi untuk menyimpan data Gas
    public function storeGas(Request $request)
    {
        $log = GasLog::create([
            'ppm_level' => $request->gas,
            'status'    => ($request->gas > 400) ? 'Bahaya' : 'Aman',
            'helmet_id' => $request->helmet_id ?? 'HELM-01'
        ]);

        return response()->json(['message' => 'Data Gas Berhasil Disimpan', 'data' => $log], 201);
    }

    // Fungsi untuk menyimpan data Suhu & Kelembaban
    public function storeTemperature(Request $request)
    {
        // Logika penentuan status sesuai kode frontend Anda
        $status = 'Normal';
        if ($request->suhu > 40 || $request->suhu < 10) {
            $status = 'Tidak Normal';
        } elseif ($request->suhu < 15 || $request->suhu > 35) {
            $status = 'Butuh Penyesuaian';
        }

        $log = TemperatureLog::create([
            'temperature' => $request->suhu,
            'humidity'    => $request->kelembaban,
            'status'      => $status,
            'helmet_id'   => $request->helmet_id ?? 'HELM-01'
        ]);

        return response()->json(['message' => 'Data Suhu Berhasil Disimpan', 'data' => $log], 201);
    }
}