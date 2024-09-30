<?php 

namespace App\Helpers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use GuzzleHttp\Client;
use Carbon\Carbon;

class UserInfoHelper
{
    public static function trackUserInfo(Request $request)
    {
        $ipAddress = $request->ip();
        //$ipAddress = "100.160.20.200"; // For testing purposes
    
        $agent = new Agent();
        $browserName = $agent->browser();
        $browserVersion = $agent->version($browserName);
        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

        $currentDateTime = Carbon::now();

        // Initialize location data
        $country = null;
        $city = null;
        $latitude = null;
        $longitude = null;

        // Only get location data for public IP addresses
        if ($ipAddress !== '127.0.0.1') {
            $client = new Client();
            $response = $client->get("http://ipinfo.io/{$ipAddress}/json");
            $locationData = json_decode($response->getBody());

            $country = $locationData->country ?? null;
            $city = $locationData->city ?? null;
            if (isset($locationData->loc)) {
                [$latitude, $longitude] = explode(',', $locationData->loc);
            }
        }

        return [
            'ip_address' => $ipAddress,
            'browser_name' => $browserName,
            'browser_version' => $browserVersion,
            'device_type' => $deviceType,
            'current_date_time' => $currentDateTime,
            'country' => $country,
            'city' => $city,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
    }
}
?>