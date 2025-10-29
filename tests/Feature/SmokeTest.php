<?php

namespace Tests\Feature;

use Tests\TestCase;

class SmokeTest extends TestCase
{
    /** @test */
    public function smoke_test_always_passes(): void
    {
        $this->assertTrue(true);
        $this->assertEquals(4, 2 + 2);
        $this->assertNotEmpty(config('app.name'));
    }
}
