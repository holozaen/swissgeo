<?php


namespace SwissGeo;


use SwissGeo\Gateways\GeoAdminGateway;
use SwissGeo\Gateways\SwissPostGateway;
use SwissGeo\Interfaces\Geocoding;
use SwissGeo\Interfaces\ReverseGeocoding;

class SwissGeo implements Geocoding, ReverseGeocoding
{
    public static function findPostcodeByPoint(float $x, float $y): ?int
    {
        $locations = GeoAdminGateway::getLocationsByGeometryPoint($x, $y);
        if (count($locations['results']) === 0) {
            return null;
        }
        $firstElement = $locations['results'][0];
        return $firstElement['attributes']['plz'];
    }

    public static function findPostcodeByCity(string $location): ?int
    {
        $currentLocation = self::findPointByAddress($location);
        if (!$currentLocation) {
            return null;
        }
        return self::findPostcodeByPoint($currentLocation['x'], $currentLocation['y']);
    }

    public static function findCityByPoint(float $x, float $y): ?string
    {
        $locations = GeoAdminGateway::getLocationsByGeometryPoint($x, $y);
        if (count($locations['results']) === 0) {
            return null;
        }
        $firstElement = $locations['results'][0];
        return $firstElement['attributes']['langtext'];
    }

    public static function findPointByAddress(string $location): ?array
    {
        $points = GeoAdminGateway::findLocations($location);
        if (count($points['results']) === 0) {
            return null;
        }
        $firstElement = $points['results'][0];
        return ['x' => $firstElement['attrs']['x'], 'y' => $firstElement['attrs']['y']];
    }

    public static function findCitiesNearPoint(float $x, float $y, float $radius): ?array
    {
        $locations = GeoAdminGateway::getLocationsByGeometryPoint($x, $y, $radius);
        if (count($locations['results']) === 0) {
            return null;
        }
        $cityArray = [];
        foreach ($locations['results'] as $location) {
            $cityArray[] = $location['attributes']['langtext'];
        }
        return $cityArray;
    }

    public static function findCitiesNearAddress(string $location, float $radius = 0): ?array
    {
        $currentLocation = self::findPointByAddress($location);
        if (!$currentLocation) {
            return null;
        }
        return self::findCitiesNearPoint($currentLocation['x'], $currentLocation['y'], $radius);
    }

    public static function findStreetnames(string $searchTerm): ?array
    {
        $result = SwissPostGateway::findStreets($searchTerm);
        if (count($result['records']) === 0) {
            return null;
        }
        $streetArray = [];
        foreach ($result['records'] as $street) {
            $streetArray[] = $street['fields']['strbezk'];
        }
        return $streetArray;
    }

    public static function findCityByPostcode(int $postcode): ?string
    {
        return SwissPostGateway::getCityByPostcode($postcode);
    }

    public static function findCantonByPostcode(int $postcode): ?string
    {
        return SwissPostGateway::getCantonByPostcode($postcode);
    }

    public static function findCantonByCity(string $name): ?string
    {
        return SwissPostGateway::getCantonByCity($name);
    }
}
