<?php

namespace oscarpalmer\Azura\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use oscarpalmer\Azura\Azura;

class AzuraTest extends TestCase {
    public function setUp(): void
    {
        $this->directory = dirname(__FILE__) . '/templates';
    }

    public function testConstructor(): void
    {
        $azura = new Azura;

        $this->assertNotNull($azura);
        $this->assertInstanceOf('\oscarpalmer\Azura\Azura', $azura);
    }

    public function testTemplate(): void {
        $azura = new Azura;

        try {
            $template = $azura->template($this->directory . '/not_a_template.phtml');
        } catch (Exception $exception) {
            $this->assertInstanceOf('\LogicException', $exception);
        }

        $template = $azura->template($this->directory . '/simple.phtml');

        $this->assertInstanceOf('oscarpalmer\Azura\Template', $template);
    }

    public function testVersion(): void
    {
        $this->assertIsString(Azura::VERSION);
    }
}
