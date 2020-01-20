<?php

namespace SwissGeo;

use PHPUnit\Framework\TestCase;

class SwissGeoTest extends TestCase
{

    public function testFindCitiesNearAddress()
    {
        $this->assertCount(2,SwissGeo::findCitiesNearAddress('Malters', 1.5));
        $this->assertCount(1,SwissGeo::findCitiesNearAddress('Malters'));
        $this->assertEquals(['Malters'], SwissGeo::findCitiesNearAddress('Malters'));
    }

    public function testFindPointByAddress()
    {
        $point = SwissGeo::findPointByAddress('Malters');
        $this->assertEqualsWithDelta(210318,$point['x'] ,1);
    }

    public function testFindCitiesNearPoint()
    {
        $this->assertCount(2,SwissGeo::findCitiesNearPoint(210318.1875, 657089.5,1.5));
        $this->assertCount(1,SwissGeo::findCitiesNearPoint(210318.1875, 657089.5));
    }

    public function testFindPostcodeByCity()
    {
        $this->assertEquals('6102',SwissGeo::findPostcodeByCity('Malters'));
    }

    public function testFindCityByPostcode()
    {
        $this->assertEquals('Malters',SwissGeo::findCityByPostcode('6102'));
    }

    public function testFindCantonByPostcode()
    {
        $this->assertEquals('LU',SwissGeo::findCantonByPostcode('6102'));
    }

    public function testFindCantonByCity()
    {
        $this->assertEquals('LU',SwissGeo::findCantonByCity('Malters'));
    }

    public function testFindCityByPoint()
    {
        $this->assertEquals('Malters',SwissGeo::findCityByPoint(210318.1875, 657089.5));
    }

    public function testFindPostcodeByPoint()
    {
        $this->assertEquals('6102',SwissGeo::findPostcodeByPoint(210318.1875, 657089.5));
    }

    public function testFindPossibleStreetnames()
    {
        $this->assertCount(1, SwissGeo::findStreetnames('Haldenhüslistrasse'));
        $this->assertEquals('Haldenhüslistrasse', SwissGeo::findStreetnames('Haldenhüslistrasse')['0']);
        $this->assertCount(10, SwissGeo::findStreetnames('Halde'));
    }
}
