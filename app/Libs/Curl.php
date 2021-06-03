<?php

namespace App\Libs;

class Curl
{
    /**
     * get请求
     *
     * @param string $url
     * @param array $curlOptions
     * @return void
     */
    public static function get($url = '', $curlOptions = [])
    {
        $curl = curl_init();
        $optionArr = [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ];
        if (
            is_array($curlOptions) &&
            count($curlOptions) > 0
        ) {
            foreach ($curlOptions as $key => $value) {
                $optionArr[$key] = $value;
            }
        }
        curl_setopt_array($curl, $optionArr);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    /**
     * 简易post请求
     *
     * @param string $url
     * @param string $data
     * @param array $curlOptions
     * @return void
     */
    public static function post($url = '', $data = '', $curlOptions = [])
    {
        $curl = curl_init();
        $optionArr = [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ];
        if (
            is_array($curlOptions) &&
            count($curlOptions) > 0
        ) {
            foreach ($curlOptions as $key => $value) {
                $optionArr[$key] = $value;
            }
        }

        curl_setopt_array($curl, $optionArr);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    /**
     * http请求，调用当前类的get和post方法
     *
     * @param string $method
     * @param string $url
     * @param array $postParamData
     * @param array $options
     * @param array $curlOptions
     * @return void
     */
    public static function httpRequest($method = 'get', $url = '', $postParamData = [], $curlOptions = [], $options = [])
    {
        $res = '';
        if (strtolower($method) == 'get') {
            $res = self::get($url, $curlOptions);
        } elseif (strtolower($method) == 'post') {
            if (
                is_array($postParamData) &&
                count($postParamData) > 0
            ) {
                $encodeParam = isset($options['encodeParam']) ? $options['encodeParam'] : true;
                $postParamData = $encodeParam ? json_encode($postParamData) : $postParamData;
            }

            $res = self::post($url, $postParamData, $curlOptions);
        }

        return $res;
    }
}
