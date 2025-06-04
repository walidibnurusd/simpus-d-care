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

        $clientId = env('Client_ID_SANDBOX');
        $clientSecret = env('Client_Secret_SANDBOX');
        $authUrl = env('Satu_Sehat_Auth_Url');

        // Log the credentials and URL for debugging purposes
        \Log::info('Auth Request URL: ' . $authUrl . '/accesstoken');
        \Log::info('Auth Request Data: ', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]);

        $response = Http::asForm()->post("$authUrl/accesstoken?grant_type=client_credentials", [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]);
        
        

        // Log the full response body to capture details
        \Log::info('Auth Response: ', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if ($response->failed()) {
            \Log::error('Failed to get access token.');
            throw new \Exception('Failed to get access token');
        }

        $data = $response->json();

        // Log the response and token details
        \Log::info('Token Response: ', ['data' => $data]);

        $token = $data['access_token'] ?? null;
        if ($token === null) {
            \Log::error('Access token not found in response');
            throw new \Exception('Access token not found');
        }

        $expiresIn = $data['expires_in'];
        \Log::info('Access Token Retrieved: ' . $token);

        Cache::put('satu_sehat_token', $token, now()->addSeconds($expiresIn - 60));

        return $token;
    }

    public static function getPatientByNik($nik)
    {
        $token = self::getSatuSehatToken();
        \Log::info('Using Token: ' . $token);
        $baseUrl = env('Satu_Sehat_Url');

        try {
            $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,  
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->get("$baseUrl/fhir-r4/v1/Patient", [
                'identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik,
            ]);
            

            \Log::info('Patient Request Response: ', [
                'url' => "$baseUrl/Patient?identifier=https://fhir.kemkes.go.id/id/nik|$nik",
                'status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            if ($response->failed()) {
                \Log::error('Failed to retrieve patient data from SatuSehat.');
                throw new \Exception('Failed to retrieve patient data from SatuSehat.');
            }

            $body = $response->json();

            if (empty($body['entry']) || ($body['total'] ?? 0) == 0) {
                throw new \Exception("No patient found with NIK: $nik");
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
        $baseUrl = env('Satu_Sehat_Url');

        try {
            $response = Http::withToken($token)->get("$baseUrl/Practitioner", [
                'identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik,
            ]);

            \Log::info('Doctor Request Response: ', [
                'url' => "$baseUrl/Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|$nik",
                'status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            if ($response->failed()) {
                \Log::error('Failed to retrieve doctor data from SatuSehat');
                throw new \Exception('Failed to retrieve doctor data from SatuSehat.');
            }

            $body = $response->json();

            if (empty($body['entry']) || ($body['total'] ?? 0) == 0) {
                throw new \Exception("Doctor with NIK $nik not found.");
            }

            $resource = $body['entry'][0]['resource'];

            return [
                'id' => $resource['id'],
                'name' => $resource['name'][0]['text'] ?? 'Name Not Found',
            ];
        } catch (\Exception $e) {
            \Log::error('Error occurred while fetching doctor data', [
                'nik' => $nik,
                'error_message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public static function postEncounterToSatuSehat($data)
    {
        $token = self::getSatuSehatToken(); 
        $baseUrl = env('Satu_Sehat_Url');

        try {
            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/fhir+json',
                    'Accept' => 'application/fhir+json',
                ])
                ->post("$baseUrl/Encounter", $data);

            \Log::info('Encounter Post Response: ', [
                'status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            if ($response->failed()) {
                \Log::error('Failed to post encounter data.');
                throw new \Exception('Failed to send Encounter: ' . $response->body());
            }

            return $response->json();
        } catch (\Exception $e) {
            \Log::error('Error occurred while posting encounter data', [
                'error_message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
