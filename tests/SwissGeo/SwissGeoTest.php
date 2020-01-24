<?php

namespace SwissGeo;

use PHPUnit\Framework\TestCase;

class SwissGeoTest extends TestCase
{

    public function testFindCitiesNearAddress(): void
    {
        $this->assertCount(2,SwissGeo::findCitiesNearAddress('Malters', 1.5));
        $this->assertCount(1,SwissGeo::findCitiesNearAddress('Malters'));
        $this->assertEquals(['Malters'], SwissGeo::findCitiesNearAddress('Malters'));
    }

    public function testFindPointByAddress(): void
    {
        $point = SwissGeo::findPointByAddress('Malters');
        $this->assertEqualsWithDelta(210318,$point['x'] ,1);
    }

    public function testFindCitiesNearPoint(): void
    {
        $this->assertCount(2,SwissGeo::findCitiesNearPoint(210318.1875, 657089.5,1.5));
        $this->assertCount(1,SwissGeo::findCitiesNearPoint(210318.1875, 657089.5));
    }

    public function testFindCitiesNearLatLong(): void
    {
        $this->assertCount(2,SwissGeo::findCitiesNearLatLon(47.041442871094, 8.1898508071899,1.5));
        $this->assertCount(1,SwissGeo::findCitiesNearLatLon(47.041442871094, 8.1898508071899));
    }

    public function testFindPostcodeByCity(): void
    {
        $this->assertEquals('6102',SwissGeo::findPostcodeByCity('Malters'));
    }

    public function testFindCityByPostcode(): void
    {
        $this->assertEquals('Malters',SwissGeo::findCityByPostcode('6102'));
    }

    public function testFindCantonByPostcode(): void
    {
        $this->assertEquals('LU',SwissGeo::findCantonByPostcode('6102'));
    }

    public function testFindCantonByCity(): void
    {
        $this->assertEquals('LU',SwissGeo::findCantonByCity('Malters'));
    }

    public function testFindCityByPoint(): void
    {
        $this->assertEquals('Malters',SwissGeo::findCityByPoint(210318.1875, 657089.5));
    }

    public function testFindCityByLatLon(): void
    {
        $this->assertEquals('Malters',SwissGeo::findCityByLatLon(47.041442871094, 8.1898508071899));
    }

    public function testFindPostcodeByPoint(): void
    {
        $this->assertEquals('6102',SwissGeo::findPostcodeByPoint(210318.1875, 657089.5));
    }

    public function testFindPossibleStreetnames(): void
    {
        $this->assertCount(1, SwissGeo::findStreetnames('Haldenhüslistrasse'));
        $this->assertEquals('Haldenhüslistrasse', SwissGeo::findStreetnames('Haldenhüslistrasse')['0']);
        $this->assertCount(10, SwissGeo::findStreetnames('Halde'));
    }
}
