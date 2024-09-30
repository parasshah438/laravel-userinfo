<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UserInfoHelper;
use App\Models\UserInfo;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $userInfo = UserInfoHelper::trackUserInfo($request);

        //Check for existing record
        $existingRecord = UserInfo::where('ip_address', $userInfo['ip_address'])->first();

        if ($existingRecord) {
            //Update
            $existingRecord->update([
                'browser_name' => $userInfo['browser_name'],
                'browser_version' => $userInfo['browser_version'],
                'device_type' => $userInfo['device_type'],
                'current_date_time' => $userInfo['current_date_time'],
                'country' => $userInfo['country'],
                'city' => $userInfo['city'],
                'latitude' => $userInfo['latitude'],
                'longitude' => $userInfo['longitude'],
            ]);
        } else {
            //Store
            UserInfo::create([
                'ip_address' => $userInfo['ip_address'],
                'browser_name' => $userInfo['browser_name'],
                'browser_version' => $userInfo['browser_version'],
                'device_type' => $userInfo['device_type'],
                'current_date_time' => $userInfo['current_date_time'],
                'country' => $userInfo['country'],
                'city' => $userInfo['city'],
                'latitude' => $userInfo['latitude'],
                'longitude' => $userInfo['longitude'],
            ]);
        }

        return response()->json($userInfo);
    }
}
