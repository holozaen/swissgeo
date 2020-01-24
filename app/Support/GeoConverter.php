<?php /** @noinspection CallableParameterUseCaseInTypeContextInspection */


namespace SwissGeo\Support;


class GeoConverter
{
    public static function latLonToPoint(float $lat, float $lon): array
    {

        // Converts decimal degrees sexagesimal seconds
        $lat = self::decimalAngleToSexagesimalSeconds($lat);
        $lon = self::decimalAngleToSexagesimalSeconds($lon);

        // Auxiliary values (% Bern)
        $lat_aux = ($lat - 169028.66)/10000;
        $lon_aux = ($lon - 26782.5)/10000;

        $x = 200147.07
            + 308807.95 * $lat_aux
            +   3745.25 * ($lon_aux ** 2)
            +     76.63 * ($lat_aux ** 2)
            -    194.56 * ($lon_aux ** 2) * $lat_aux
            +    119.79 * ($lat_aux ** 3);

        $y = 600072.37
            + 211455.93 * $lon_aux
            -  10938.51 * $lon_aux * $lat_aux
            -      0.36 * $lon_aux * ($lat_aux ** 2)
            -     44.54 * ($lon_aux ** 3);

        return ['x' => $x, 'y' => $y];
    }

    public static function pointToLatLon(float $x, float $y): array
    {
        // Converts military to civil and  to unit = 1000km
        // Auxiliary values (% Bern)
        $y_aux = ($y - 600000)/1000000;
        $x_aux = ($x - 200000)/1000000;

        // Process lat
        $lat = 16.9023892
            +  3.238272 * $x_aux
            -  0.270978 * ($y_aux ** 2)
            -  0.002528 * ($x_aux ** 2)
            -  0.0447   * ($y_aux ** 2) * $x_aux
            -  0.0140   * ($x_aux ** 3);

        // Unit 10000" to 1 " and converts seconds to degrees (dec)
        $lat = $lat * 100/36;

        // Process long
        $lon = 2.6779094
            + 4.728982 * $y_aux
            + 0.791484 * $y_aux * $x_aux
            + 0.1306   * $y_aux * ($x_aux ** 2)
            - 0.0436   * ($y_aux ** 3);

        // Unit 10000" to 1 " and converts seconds to degrees (dec)
        $lon = $lon * 100/36;

        return ['lat' => $lat, 'lon' => $lon];
    }


    private static function decimalAngleToSexagesimalSeconds(float $angle)
    {
        // Extract DMS
        $deg = (int)$angle;
        $min = (int)(($angle - $deg) * 60);
        $sec =  ((($angle-$deg)*60)-$min)*60;

        // Result in sexagesimal seconds
        return $sec + $min*60 + $deg*3600;
    }
}
