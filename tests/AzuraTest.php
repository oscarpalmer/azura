<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use oscarpalmer\Azura\Azura;

mb_internal_encoding('utf-8');

class AzuraTest extends TestCase {
    public function setUp(): void
    {
        $this->directory = dirname(__FILE__) . '/templates';
    }

    public function testConstructor(): void
    {
        $azura = new Azura($this->directory);

        $this->assertNotNull($azura);
        $this->assertInstanceOf('\oscarpalmer\Azura\Azura', $azura);
    }

    public function testGetFile(): void
    {
        $azura = new Azura($this->directory, 'phtml');

        try {
            $azura->template('');
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }

        try {
            $azura->template('simple.phtml');
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }
    }

    public function testSetDirectory(): void
    {
        try {
            $azura = new Azura('');
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }
    }

    public function testSetExtension(): void
    {
        try {
            $azura = new Azura($this->directory, '');
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }

        try {
            $azura = new Azura($this->directory, 'phtml');
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }

        try {
            $azura = new Azura($this->directory, '.phtml');
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }
    }

    public function testTemplate(): void {
        $azura = new Azura($this->directory);

        try {
            $template = $azura->template('not_a_template');
        } catch (Exception $exception) {
            $this->assertInstanceOf('\LogicException', $exception);
        }

        $template = $azura->template('simple');

        $this->assertInstanceOf('oscarpalmer\Azura\Template', $template);
    }

    public function testVersion(): void
    {
        $this->assertIsString(Azura::VERSION);
    }
}
