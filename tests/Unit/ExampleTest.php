<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    /**
     * Ejemplo de prueba unitaria
     *
     * @return void
     */
    public function testUnitTest()
    {
        $statusCode = 200;
        $this->assertTrue(200 == $statusCode, 'El status code es 200');
    }
}
