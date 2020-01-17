<?php


namespace SwissGeo\Gateways;

use SwissGeo\Support\Http;
use SwissGeo\Exceptions\ApiException;

class GeoAdminGateway
{
    public static function getLocationsByGeometryPoint(float $x, float $y, float $radius = 0, array $options = []): ?array
    {
        $url = 'https://api3.geo.admin.ch/rest/services/api/MapServer/identify';

        $params = array_merge([
            'lang' => 'de',
            'geometryType' => 'esriGeometryPoint',
            'layers' => 'all:ch.swisstopo-vd.ortschaftenverzeichnis_plz',
            'mapExtent' => '0,0,100,100',
            'imageDisplay' => '100,100,100',
            'returnGeometry' => false
         ], $options);

        $params['geometry'] = $y.','.$x;
        $params['tolerance'] = $radius * 1000;
        try {
            return Http::get($url, $params);
        } catch (ApiException $e) {
            return null;
        }
    }

    public static function findLocations(string $searchText, array $options = []): ?array
    {
        $url = 'https://api3.geo.admin.ch/rest/services/api/SearchServer';

        $params = array_merge([
            'type' => 'locations',
        ], $options);
        $params['searchText'] = $searchText;

        try {
            return Http::get($url, $params);
        } catch (ApiException $e) {
            return null;
        }
    }
}
