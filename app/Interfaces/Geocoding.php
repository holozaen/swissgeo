<?php


namespace SwissGeo\Interfaces;

/**
 * $radius means distance in km
 */

interface Geocoding
{
    public static function findStreetnames(string $searchTerm): ?array;
    public static function findPostcodeByCity(string $location) : ?int;
    public static function findCityByPostcode(int $postcode) : ?string;
    public static function findPointByAddress(string $location) : ?array;
    public static function findCitiesNearAddress(string $location, float $radius): ?array;
    public static function findCantonByPostcode(int $postcode): ?string;
    public static function findCantonByCity(string $name): ?string;

}
