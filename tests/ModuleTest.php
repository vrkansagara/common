<?php

declare(strict_types=1);

namespace Vrkansagara\Common;

/**
 * @copyright  Copyright (c) 2015-2022 Vallabh Kansagara <vrkansagara@gmail.com>
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 */

use PHPUnit\Framework\TestCase;

class ModuleTest extends TestCase
{
    /** @test */
    public function index()
    {
        $response = ( true === true );

        $this->assertIsBool($response);
    }
}
