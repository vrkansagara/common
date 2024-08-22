<?php

declare(strict_types=1);

namespace Vrkansagara\Common\Helpers;

use PHPUnit\Framework\TestCase;

use function getIpecho;
use function sprintf;

class IpTest extends TestCase
{
    public function testGetIpechoIp()
    {
        $getIpechoData = getIpecho();

        echo sprintf("Your current ip is %s", $getIpechoData);

        $this->assertIsString($getIpechoData);
    }
}
