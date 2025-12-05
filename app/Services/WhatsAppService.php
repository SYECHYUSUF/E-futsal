<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $token;

    public function __construct()
    {
        // Token diambil dari file index.php yang Anda berikan
        // Sebaiknya nanti dipindah ke .env (FONNTE_TOKEN=nbbXMT5fWHrhRs7VPBK7)
        $this->token = env('FONNTE_TOKEN', 'nbbXMT5fWHrhRs7VPBK7');
    }

    /**
     * Kirim pesan WhatsApp via Fonnte API
     */
    public function sendMessage($target, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Opsional, default 62
            ]);

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