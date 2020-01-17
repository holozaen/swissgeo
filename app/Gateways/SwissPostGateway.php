<?php


namespace SwissGeo\Gateways;


use SwissGeo\Exceptions\ApiException;
use SwissGeo\Support\Http;

class SwissPostGateway
{
    public static function findStreets(string $searchTerm, array $options = []): ?array
    {
        $url = 'https://swisspost.opendatasoft.com/api/records/1.0/search';

        $params = array_merge([
            'dataset' => 'strassenbezeichnungen_v2',
        ], $options);

        $params['q'] = $searchTerm;

        try {
            return Http::get($url, $params);
        } catch (ApiException $e) {
            return null;
        }
    }

    public static function getCityByPostcode(int $postcode, array $options = []): ?string
    {
        $record = self::getCityRecordByPostcode($postcode, $options);
        return $record['fields']['ortbez18'];
    }

    public static function getCantonByPostcode(int $postcode, array $options = []): ?string
    {
        $record = self::getCityRecordByPostcode($postcode, $options);
        return $record['fields']['kanton'];
    }

    public static function getCantonByCity(string $name, array $options = []): ?string
    {
        $record = self::getCityRecordByName($name, $options);
        return $record['fields']['kanton'];
    }

    public static function getCityRecordByPostcode(int $postcode, array $options = []): ?array
    {
        $url = 'https://swisspost.opendatasoft.com/api/records/1.0/search';

        $params = array_merge([
            'dataset' => 'plz_verzeichnis_v2',
        ], $options);

        $params['q'] = "(postleitzahl={$postcode})";
        $params['exclude.plz_typ'] = 80;
        try {
            $response = Http::get($url, $params);
            if (!$response || !array_key_exists('records', $response) || count($response['records']) === 0) {
                return null;
            }
            return $response['records'][0];
        } catch (ApiException $e) {
            return null;
        }
    }

    public static function getCityRecordByName(string $name, array $options = []): ?array
    {
        $url = 'https://swisspost.opendatasoft.com/api/records/1.0/search';

        $params = array_merge([
            'dataset' => 'plz_verzeichnis_v2',
        ], $options);

        $params['q'] = "(ortbez18={$name})";
        $params['exclude.plz_typ'] = 80;
        try {
            $response = Http::get($url, $params);
            if (!$response || !array_key_exists('records', $response) || count($response['records']) === 0) {
                return null;
            }
            return $response['records'][0];
        } catch (ApiException $e) {
            return null;
        }
    }
}
