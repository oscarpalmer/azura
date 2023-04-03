<?php

declare(strict_types=1);

namespace oscarpalmer\Azura;

use LogicException;

final class Configuration
{
	/**
	 * @var array<string>
	 */
	private array $values = [
		'directory' => '.',
		'encoding' => 'utf-8',
		'extension' => 'phtml',
	];

	/**
	 * @param array<string> $configuration
	 */
	public function __construct(array $configuration = [])
	{
		$this->values['encoding'] = $this->getValidEncoding($configuration['encoding'] ?? $this->values['encoding']);

		$this->values['directory'] = $this->getValidDirectory($configuration['directory'] ?? $this->values['directory']);
		$this->values['extension'] = $this->getValidExtension($configuration['extension'] ?? $this->values['extension']);
	}

	/**
	 * Get directory for template files
	 */
	public function getDirectory(): string
	{
		return $this->values['directory'];
	}

	/**
	 * Get encoding for output
	 */
	public function getEncoding(): string
	{
		return $this->values['encoding'];
	}

	/**
	 * Get extension for templates
	 */
	public function getExtension(): string
	{
		return $this->values['extension'];
	}

	private function getValidDirectory(string $directory): string
	{
		if (! is_dir($directory)) {
			throw new LogicException('The provided directory does not exist');
		}

		return $directory;
	}

	private function getValidEncoding(string $encoding): string
	{
		$encodings = mb_list_encodings();
		$normalized = mb_strtolower($encoding, 'utf-8');

		foreach ($encodings as $encoding) {
			if (mb_strtolower($encoding, 'utf-8') === $normalized) {
				return $encoding;
			}
		}

		throw new LogicException('The provided encoding does not exist');
	}

	private function getValidExtension(string $extension): string
	{
		if (mb_strlen($extension, $this->getEncoding()) === 0) {
			throw new LogicException('The provided extension may not be empty');
		}

		if (mb_substr($extension, 0, 1) !== '.') {
			return $extension;
		}

		$extension = ltrim($extension, '.');

		return ".{$extension}";
	}
}
