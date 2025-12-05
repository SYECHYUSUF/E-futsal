<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class WhatsAppService
 * * Service khusus untuk menangani integrasi dengan API Fonnte.
 * Digunakan untuk mengirim notifikasi otomatis ke WA user/admin.
 */
class WhatsAppService
{
    protected $token;

    public function __construct()
    {
        // Mengambil token Fonnte dari file .env untuk keamanan
        $this->token = env('FONNTE_TOKEN');
    }

    /**
     * Mengirim pesan teks ke nomor WhatsApp target.
     *
     * @param string $target Nomor HP tujuan (contoh: 08123...)
     * @param string $message Isi pesan yang akan dikirim
     * @return bool True jika sukses, False jika gagal
     */
    public function sendMessage($target, $message)
    {
        try {
            // Melakukan HTTP POST request ke endpoint API Fonnte
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Default kode negara Indonesia
            ]);

            // Logging hasil pengiriman untuk debugging
            if ($response->successful()) {
                Log::info("WA Terkirim ke {$target}");
                return true;
            } else {
                Log::error("Gagal kirim WA Fonnte: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Exception WA Service: ' . $e->getMessage());
            return false;
        }
    }
}