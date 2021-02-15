<?php

namespace SendGrid\Test;

use PHPUnit\Framework\TestCase;

class LicenceYearTest extends TestCase
{
    public function testLicenseYear()
    {
        $rootDir = __DIR__ . '/../..';

        $license = explode("\n", file_get_contents("$rootDir/LICENSE"));
        $copyright = trim($license[2]);

        $year = date('Y');

        $expected = "Copyright (C) {$year}, Twilio SendGrid, Inc. <help@twilio.com>";

        $this->assertEquals($expected, $copyright);
    }
}
