<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $backendUrl;

    public function __construct()
    {
        // URL ke file index.php di folder backend Anda.
        // Sesuaikan jika port atau nama foldernya beda.
        $this->backendUrl = 'http://localhost/efutsal-backend/index.php';
    }

    /**
     * Mengirim request ke Backend PHP Native untuk memproses WA
     *
     * @param string $target Nomor HP tujuan
     * @param string $message Isi pesan
     * @return bool
     */
    public function sendMessage($target, $message)
    {
        try {
            // Kita "tembak" file backend Anda dengan membawa data target & text
            $response = Http::get($this->backendUrl, [
                'target' => $target,
                'text'   => $message,
            ]);

            // Cek log laravel (storage/logs/laravel.log) untuk debugging
            if ($response->successful()) {
                Log::info("WA Terkirim ke Backend: {$target}");
                return true;
            } else {
                Log::error("Gagal konek ke Backend WA: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Exception WA Service: ' . $e->getMessage());
            return false;
        }
    }
}