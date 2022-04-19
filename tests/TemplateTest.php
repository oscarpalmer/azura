<?php

namespace oscarpalmer\Azura\Test;

use oscarpalmer\Azura\Azura;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase {
    public function setUp(): void
    {
        $this->simple_template = dirname(__FILE__) . '/templates/simple.phtml';
        $this->simple_output = file_get_contents($this->simple_template);
    }

    public function testConstructor(): void {
        $template = (new Azura)->template($this->simple_template);

        $this->assertNotNull($template);
        $this->assertInstanceOf('oscarpalmer\Azura\Template', $template);
    }

    public function testToString(): void {
        $template = (new Azura)->template($this->simple_template);

        $this->assertEquals((string) $template, $this->simple_output);
    }

    public function testRender(): void {
        $template = (new Azura)->template($this->simple_template);

        $this->expectOutputString($this->simple_output);

        $template->render();
    }
}
