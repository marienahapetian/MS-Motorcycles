<?php

namespace App\Tests\Product;

use PHPUnit\Framework\TestCase;

class RetrieveTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testContains(): void
    {
        $this->assertContains(4, [1, 2, 3, 4]);
    }

    public function testEquals(): void
    {
        $this->assertEquals(4, [1, 2, 3, 4]);
    }
}
