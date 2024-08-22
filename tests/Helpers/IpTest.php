<?php

namespace Vrkansagara\Common\Helpers;

use PHPUnit\Framework\TestCase;

class IpTest extends TestCase
{
    public function testGetIpechoIp()
    {
        $getIpechoData = getIpecho();

        $this->assertIsString($getIpechoData);
    }
}
