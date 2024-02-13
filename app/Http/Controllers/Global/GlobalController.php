<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use Aditdev\ApiGames;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function rupiah($angka)
    {
        $result = 'Rp. ' . number_format($angka, 0, ',', '.');
        return $result;
    }

    public function cekId(Request $request)
    {
        $api = new ApiGames();
        if($request->slug == 'mobile-legend') {
            $result = $api->MOBILE_LEGENDS($request->userId, $request->serverId);        
        } elseif($request->slug == 'call-of-duty-mobile') {
            $result = $api->CALL_OF_DUTY($request->userId);  
        } 
        return json_decode($result);
    }
}
