<?php


namespace SwissGeo\Support;


use Exception;
use SwissGeo\Exceptions\ApiException;

class Http
{
    /**
     * @param string $url
     * @param array $params
     * @return array
     * @throws ApiException
     */
    public static function get(string $url, array $params = []): array
    {
        if (count($params) > 0) {
            $url .= '?' . http_build_query($params);
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 3,
            CURLOPT_URL =>  $url,
            CURLOPT_USERAGENT => 'geocoding agent',
            CURLOPT_FAILONERROR => true
        ]);

        try {
            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                throw new ApiException(curl_error($curl));
            }
            /** @noinspection JsonEncodingApiUsageInspection */
            return json_decode($response, true, 512);
        } catch (Exception $e){
            throw new ApiException($e);
        } finally {
            curl_close($curl);
        }
    }
}
