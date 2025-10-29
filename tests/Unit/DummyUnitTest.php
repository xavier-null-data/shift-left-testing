<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DummyUnitTest extends TestCase
{
    /** @test */
    public function unit_test_always_passes(): void
    {
        $sum = 2 + 2;
        $this->assertEquals(4, $sum);
        $array = ['invoice' => 123, 'valid' => true];
        $this->assertTrue($array['valid']);
        $this->assertArrayHasKey('invoice', $array);
    }
}
