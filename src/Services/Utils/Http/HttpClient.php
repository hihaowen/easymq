<?php
/**
 * Filename: HttpClient.php.
 * User: George
 * Date: 2018/4/27
 * Time: 上午11:07
 */

namespace Services\Utils\Http;

class HttpClient {

    const CONNECT_TIMEOUT_MS = 3000;

    const TIMEOUT_MS = 3000;

    final static function request($method, $url = '/', $body, array $headers = [], $debug = false) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, self::CONNECT_TIMEOUT_MS);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, self::TIMEOUT_MS);

        // 允许抓取请求的header
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $response = curl_exec($ch);

        // for debug

        if($debug) {

            $curl_headers = curl_getinfo($ch, CURLINFO_HEADER_OUT);

            echo 'http request:', PHP_EOL;

            echo $curl_headers, PHP_EOL;
        }

        if( $errno = curl_errno($ch) ) {

            $error = curl_error($ch);

            curl_close($ch);

            throw new \RuntimeException('请求失败: ' . $error);
        }

        $response_info = curl_getinfo($ch);

        // echo PHP_EOL;
        // echo 'http response:', PHP_EOL;

        // print_r($response);

        // echo PHP_EOL;
        // echo 'http status code: ' . $response_info['http_code'], PHP_EOL;

        curl_close($ch);

        return $response;
    }

}