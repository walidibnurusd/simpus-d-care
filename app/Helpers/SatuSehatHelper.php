<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SatuSehatHelper
{
    public static function getSatuSehatToken()
    {
        if (Cache::has('satu_sehat_token')) {
            return Cache::get('satu_sehat_token');
        }

        $clientId = config('satusehat.client_id');
        $clientSecret = config('satusehat.client_secret');
        $authUrl = config('satusehat.auth_url');
        Log::info('Satu Sehat Auth Config:', [
            'Client_ID_SANDBOX' => $clientId,
            'Client_Secret_SANDBOX' => $clientSecret,
            'Satu_Sehat_Auth_Url' => $authUrl,
        ]);
       $url = $authUrl . '/accesstoken?grant_type=client_credentials';
        $response = Http::asForm()->post($url, [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]);
        \Log::info('Full Auth URL: ' . $authUrl . '/accesstoken');
        if ($response->failed()) {
            throw new \Exception('Failed to get access token');
        }

        $data = $response->json();
        Log::info('data: ' . json_encode($data));
        $token = $data['access_token'];
        $expiresIn = $data['expires_in'];
        Log::info('Token Info:', [
    'access_token' => $token,
    'expires_in' => $expiresIn,
]);


        Cache::put('satu_sehat_token', $token, now()->addSeconds($expiresIn - 60));

        return $token;
    }

    public static function getPatientByNik($nik)
{
    $token = self::getSatuSehatToken();
    \Log::info('Retrieved token: ' . $token);
    $baseUrl = config('satusehat.base_url');

    // Log token and URL to ensure they are correct
    \Log::info('Requesting Patient data with NIK: ' . $nik);
    \Log::info('Using Token: ' . $token);

    // Perform the API request
    try {
        $response = Http::withToken($token) // Token diambil dari helper
            ->withHeaders([
                'Content-Type' => 'application/fhir+json',
                'Accept' => 'application/fhir+json',
            ])
            ->get("$baseUrl/Patient", [
                'identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik,
            ]);

        // Log the request URL and response body
        \Log::info('Request URL: ', [
            'url' => "$baseUrl/Patient?identifier=https://fhir.kemkes.go.id/id/nik|$nik",
            'response_status' => $response->status(),
            'response_body' => $response->body(),
        ]);

        // Check if request failed
        if ($response->failed()) {
            \Log::error('Failed to retrieve patient data from SatuSehat', [
                'nik' => $nik,
                'error_response' => $response->body(),
            ]);
            throw new \Exception('Gagal mengambil data pasien dari SatuSehat.');
        }

        $body = $response->json();

        // Check if patient data exists
        if (empty($body['entry']) || ($body['total'] ?? 0) == 0) {
            \Log::error('No patient found with NIK', ['nik' => $nik]);
            throw new \Exception("Pasien dengan NIK $nik tidak ditemukan di SatuSehat.");
        }

        $resource = $body['entry'][0]['resource'];

        return [
            'id' => $resource['id'],
            'name' => $resource['name'][0]['text'] ?? 'Nama Tidak Diketahui',
        ];
    } catch (\Exception $e) {
        \Log::error('Error occurred while fetching patient data', [
            'nik' => $nik,
            'error_message' => $e->getMessage(),
        ]);
        throw $e;
    }
}
    public static function getDocterByNik($nik)
    {
        $token = self::getSatuSehatToken();
        $baseUrl = config('satusehat.base_url');

        $response = Http::withToken($token)->get("$baseUrl/Practitioner", [
            'identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik,
        ]);

        // Log semua response (baik sukses maupun gagal)
       \Log::info('Response from SatuSehat /Patient', [
            'url' => "$baseUrl/Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|$nik",
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

        if ($response->failed()) {
            Log::error('Gagal mengambil data dokter dari SatuSehat', [
                'nik' => $nik,
                'response' => $response->body(),
            ]);
            throw new \Exception('Gagal mengambil data dokter dari SatuSehat.');
        }

        $body = $response->json();

        // Jika tidak ada dokter
        if (empty($body['entry']) || ($body['total'] ?? 0) == 0) {
            Log::error('Pasien tidak ditemukan', ['nik' => $nik]);
            throw new \Exception("Pasien dengan NIK $nik tidak ditemukan di SatuSehat.");
        }

        $resource = $body['entry'][0]['resource'];

        return [
            'id' => $resource['id'],
            'name' => $resource['name'][0]['text'] ?? 'Nama Tidak Diketahui',
        ];
    }
    public static function postEncounterToSatuSehat($data)
    {
        $token = self::getSatuSehatToken(); // Ambil token dari cache / generate
        $baseUrl = config('satusehat.base_url');

        // Log the URL and token to verify they are correct
        \Log::info('Satu Sehat URL: ' . $baseUrl);
        \Log::info('Satu Sehat Token: ' . $token);

        // Debugging cURL response
        try {
            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/fhir+json',
                    'Accept' => 'application/fhir+json',
                ])
                ->post("$baseUrl/Encounter", $data);

            // Log the response status and body for debugging
            \Log::info('Response Status: ' . $response->status());
            \Log::info('Response Body: ' . $response->body());

            if ($response->failed()) {
                throw new \Exception('Failed to send Encounter: ' . $response->body());
            }

            return [
                'status' => 'success',
                'data' => $response->json(),
            ];
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error occurred: ' . $e->getMessage());
            throw $e;
        }
    }


}
