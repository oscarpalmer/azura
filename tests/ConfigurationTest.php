<?php

declare(strict_types=1);

namespace oscarpalmer\Azura\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use oscarpalmer\Azura\Configuration;

final class ConfigurationTest extends TestCase
{
	public function testValidateDirectory(): void
	{
		try {
			new Configuration([
				'directory' => '',
			]);
		} catch (Exception $exception) {
			$this->assertInstanceOf('LogicException', $exception);
		}
	}

	public function testValidateEncoding(): void
	{
		try {
			new Configuration([
				'encoding' => '',
			]);
		} catch (Exception $exception) {
			$this->assertInstanceOf('LogicException', $exception);
		}
	}

	public function testValidateExtension(): void
	{
		try {
			new Configuration([
				'extension' => '',
			]);
		} catch (Exception $exception) {
			$this->assertInstanceOf('LogicException', $exception);
		}

		try {
			new Configuration([
				'extension' => '...phtml',
			]);
		} catch (Exception $exception) {
			$this->assertInstanceOf('LogicException', $exception);
		}

		try {
			new Configuration([
				'extension' => 'phtml',
			]);
		} catch (Exception $exception) {
			$this->assertInstanceOf('LogicException', $exception);
		}
	}
}
