<?php


namespace SwissGeo\Interfaces;


interface ReverseGeocoding
{
    public static function findCitiesNearPoint(float $x, float $y, float $radius) : ?array;
    public static function findCityByPoint(float $x, float $y): ?string;
    public static function findPostcodeByPoint(float $x, float $y): ?int;
}
