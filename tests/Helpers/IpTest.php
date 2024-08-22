<?php

declare(strict_types=1);

namespace Vrkansagara\Common\Helpers;

use PHPUnit\Framework\TestCase;

use function getIpecho;

class IpTest extends TestCase
{
    public function testGetIpechoIp()
    {
        $getIpechoData = getIpecho();

        $this->assertIsString($getIpechoData);
    }
}
