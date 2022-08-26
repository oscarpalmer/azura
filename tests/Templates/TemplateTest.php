<?php

declare(strict_types=1);

namespace oscarpalmer\Azura\Test\Templates;

use oscarpalmer\Azura\Azura;
use oscarpalmer\Azura\Configuration;
use PHPUnit\Framework\TestCase;

final class TemplateTest extends TestCase {
	public Configuration $configuration;
	public string $simpleOutput;

	public function setUp(): void
	{
		$this->configuration = new Configuration([
			'directory' => dirname(__FILE__) . '/../static',
		]);

		$simpleOutput = file_get_contents("{$this->configuration->getDirectory()}/simple.phtml");

		$this->simpleOutput = $simpleOutput === false ? '' : $simpleOutput;
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

		$this->assertEquals((string) $template, $this->simpleOutput);
	}

	public function testInclude(): void
	{
		$template = (new Azura($this->configuration))->template('partial_base');

		$this->assertEquals(trim((string) $template), 'Hello, world!');
	}

	public function testLayout(): void
	{
		$template = (new Azura($this->configuration))->template('layout_inner');

		$this->assertEquals(trim((string) $template), '<h2>TITLE</h2>
<div><p>Hello world</p></div>');
	}

	public function testRender(): void
	{
		$template = (new Azura($this->configuration))->template('simple');

		$this->expectOutputString($this->simpleOutput);

		$template->render();
	}
}
