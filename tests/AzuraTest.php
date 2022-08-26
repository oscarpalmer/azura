<?php

declare(strict_types=1);

namespace oscarpalmer\Azura\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use oscarpalmer\Azura\Azura;
use oscarpalmer\Azura\Configuration;

final class AzuraTest extends TestCase {
	public Configuration $configuration;

	public function setUp(): void
	{
		$this->configuration = new Configuration([
			'directory' => dirname(__FILE__) . '/static',
		]);
	}

	public function testConstructor(): void
	{
		$azura = new Azura($this->configuration);

		$this->assertNotNull($azura);
		$this->assertInstanceOf('\oscarpalmer\Azura\Azura', $azura);
	}

	public function testGetObjects(): void
	{
		$azura = new Azura($this->configuration);

		$this->assertInstanceOf('oscarpalmer\Azura\Configuration', $azura->getConfiguration());
		$this->assertInstanceOf('oscarpalmer\Azura\Filters\Filter', $azura->getFilter());
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
