<?php

namespace Codifikdos\CodyFactSDK\Tests;

use Codifikdos\CodyFactSDK\Factura;
use PHPUnit\Framework\TestCase;

class FacturaTest extends TestCase
{
    /**
     * @test
     */
    public function itSendFactura()
    {
        $factura = new Factura();
        $sum = $factura->sendFactura();

        $this->assertSame(34, $sum);
    }
}