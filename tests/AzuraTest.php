<?php

namespace oscarpalmer\Azura\Test;

use PHPUnit\Framework\TestCase;
use oscarpalmer\Azura\Azura;

class AzuraTest extends TestCase {
    public function testConstructor(): void
    {
        $azura = new Azura;

        $this->assertNotNull($azura);
        $this->assertInstanceOf('\oscarpalmer\Azura\Azura', $azura);
    }

    public function testVersion(): void
    {
        $this->assertIsString(Azura::VERSION);
    }
}
