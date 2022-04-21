<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Test;

use oscarpalmer\Azura\Azura;
use oscarpalmer\Azura\Configuration;
use PHPUnit\Framework\TestCase;

mb_internal_encoding('UTF-8');

class TemplateTest extends TestCase {
    public function setUp(): void
    {
        $this->configuration = new Configuration;

        $this->configuration->directory = dirname(__FILE__) . '/templates';

        $this->simple_output = file_get_contents("{$this->configuration->directory}/simple.phtml");
    }

    public function testConstructor(): void
    {
        $template = (new Azura($this->configuration))->template('simple');

        $this->assertNotNull($template);
        $this->assertInstanceOf('oscarpalmer\Azura\Templates\Template', $template);
    }

    public function testToString(): void
    {
        $template = (new Azura($this->configuration))->template('simple');

        $this->assertEquals((string) $template, $this->simple_output);
    }

    public function testInclude(): void
    {
        $template = (new Azura($this->configuration))->template('partial_base');

        $this->assertEquals(trim((string) $template), 'Hello, world!');
    }

    public function testLayout(): void
    {
        $template = (new Azura($this->configuration))->template('layout_inner');

        $this->assertEquals(trim((string) $template), '<div><p>Hello world</p></div>');
    }

    public function testRender(): void
    {
        $template = (new Azura($this->configuration))->template('simple');

        $this->expectOutputString($this->simple_output);

        $template->render();
    }
}
