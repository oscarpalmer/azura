<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use oscarpalmer\Azura\Azura;
use oscarpalmer\Azura\Configuration;

mb_internal_encoding('UTF-8');

class AzuraTest extends TestCase {
    public function setUp(): void
    {
        $this->configuration = new Configuration;

        $this->configuration->directory = dirname(__FILE__) . '/templates';
    }

    public function testConstructor(): void
    {
        $azura = new Azura($this->configuration);

        $this->assertNotNull($azura);
        $this->assertInstanceOf('\oscarpalmer\Azura\Azura', $azura);
    }

    public function testGetFile(): void
    {
        $azura = new Azura($this->configuration);

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
            $configuration = new Configuration;

            $configuration->directory = '';

            $azura = new Azura($configuration);
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }
    }

    public function testSetExtension(): void
    {
        try {
            $configuration = new Configuration;

            $configuration->extension = '';

            $azura = new Azura($configuration);
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }

        try {
            $configuration = new Configuration;

            $configuration->extension = '...phtml';

            $azura = new Azura($configuration);
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }

        try {
            $configuration = new Configuration;

            $configuration->extension = 'phtml';

            $azura = new Azura($configuration);
        } catch (Exception $exception) {
            $this->assertInstanceOf('LogicException', $exception);
        }
    }

    public function testTemplate(): void {
        $azura = new Azura($this->configuration);

        try {
            $template = $azura->template('not_a_template');
        } catch (Exception $exception) {
            $this->assertInstanceOf('\LogicException', $exception);
        }

        $template = $azura->template('simple');

        $this->assertInstanceOf('oscarpalmer\Azura\Templates\Template', $template);
    }

    public function testVersion(): void
    {
        $this->assertIsString(Azura::VERSION);
    }
}
