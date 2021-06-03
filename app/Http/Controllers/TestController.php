<?php
namespace App\Http\Controllers;


use App\Libs\Common;
use App\Libs\Curl;

class TestController extends Controller
{
    public function index()
    {

        $app_key = "27945465";
        $app_secret = "pjrwnhJFfPMeAah6Vjip";
        $base_url = "https://220.178.179.35:4443";
        $api_path = "/artemis/api/resource/v1/person/getPersonPage";
        $timestamp = intval(microtime(true)*1000);
        $content_type = "application/json;charset=UTF-8";

        $sign_data = "POST\n*/*\n$content_type\nx-ca-key:$app_key\nx-ca-timestamp:$timestamp\n$api_path";

        $signature = hash_hmac('sha256', $sign_data, $app_secret, true);
        $sign =  base64_encode($signature);

        $res = Curl::post($base_url .$api_path,'',[CURLOPT_HTTPHEADER => [
            'Accept: */*',
            'Content-Type: '.$content_type,
            'X-Ca-Key: '.$app_key,
            'X-Ca-Signature: '.$sign,
            'X-Ca-Timestamp: '.$timestamp,
            'X-Ca-Signature-Headers: x-ca-key,x-ca-timestamp',
        ]]);

        dd($res);


    }

}
