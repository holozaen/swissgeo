<?php

namespace SwissGeo;

use PHPUnit\Framework\TestCase;
use SwissGeo\Support\GeoConverter;

class GeoConverterTest extends TestCase
{
    public function testCanConvertSwissCoordinatesToLatLon(): void
    {
        $latLon = GeoConverter::pointToLatLon(210318.1875, 657089.5);
        $this->assertEqualsWithDelta(47.041442871094, $latLon['lat'], 0.01);
        $this->assertEqualsWithDelta(8.1898508071899, $latLon['lon'], 0.01);
    }

    public function testCanLatLonToSwissCoordinates(): void
    {
        $point = GeoConverter::latLonToPoint(47.041442871094, 8.1898508071899);
        $this->assertEqualsWithDelta(210318.1875, $point['x'], 1);
        $this->assertEqualsWithDelta(657089.5, $point['y'], 1);
    }

}
