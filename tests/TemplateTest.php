<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Test;

use oscarpalmer\Azura\Azura;
use PHPUnit\Framework\TestCase;

mb_internal_encoding('utf-8');

class TemplateTest extends TestCase {
    public function setUp(): void
    {
        $this->directory = dirname(__FILE__) . '/templates';

        $this->simple_output = file_get_contents("{$this->directory}/simple.phtml");
    }

    public function testConstructor(): void
    {
        $template = (new Azura($this->directory))->template('simple');

        $this->assertNotNull($template);
        $this->assertInstanceOf('oscarpalmer\Azura\Template', $template);
    }

    public function testToString(): void
    {
        $template = (new Azura($this->directory))->template('simple');

        $this->assertEquals((string) $template, $this->simple_output);
    }

    public function testRender(): void
    {
        $template = (new Azura($this->directory))->template('simple');

        $this->expectOutputString($this->simple_output);

        $template->render();
    }
}
