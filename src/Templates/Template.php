<?php

declare(strict_types=1);

namespace oscarpalmer\Azura\Templates;

use LogicException;
use oscarpalmer\Azura\Azura;
use oscarpalmer\Azura\Filters\Filter;
use stdClass;

class Template
{
	protected Azura $azura;

	protected mixed $data;

	protected string $file;

	protected stdClass $layout;

	protected string $name;

	/**
	 * @param Azura $azura Azura
	 * @param string $name Template name
	 * @param mixed $data Optional data object
	 */
	public function __construct(Azura $azura, string $name, mixed $data = null)
	{
		$this->azura = $azura;
		$this->data = $data ?? new stdClass();
		$this->layout = new stdClass();

		$this->layout->data = null;
		$this->layout->name = null;

		$this->file = $this->getFile($azura, $name);
	}

	/**
	 * Render template
	 */
	public function __toString(): string
	{
		return $this->renderFile();
	}

	/**
	 * Get filter helper
	 */
	public function getFilter(): Filter
	{
		return $this->azura->getFilter();
	}

	/**
	 * Define a layout for this template
	 *
	 * @param string $name Name of layout
	 * @param mixed $data Optional data object
	 */
	public function layout(string $name, mixed $data = null): void
	{
		$this->layout->data = $data;
		$this->layout->name = $name;
	}

	/**
	 * Render template
	 */
	public function render(): void
	{
		echo $this->renderFile();
	}

	/**
	 * Create a template
	 *
	 * @param string $name Name of template file
	 * @param mixed $data Optional data object
	 */
	public function include(string $name, mixed $data = null): Template
	{
		return $this->azura->template($name, $data ?? $this->data);
	}

	private function getFile(Azura $azura, string $name): string
	{
		if (mb_strlen($name, $azura->getConfiguration()->getEncoding()) === 0) {
			throw new LogicException('A template name may not be empty');
		}

		$extension = str_contains($name, '.')
			? ''
			: $azura->getConfiguration()->getExtension();

		$filename = "{$azura->getConfiguration()->getDirectory()}/{$name}.{$extension}";

		if (! is_file($filename)) {
			throw new LogicException('The template file does not exist');
		}

		return $filename;
	}

	private function renderFile(): string
	{
		ob_start();

		include $this->file;

		$content = ob_get_clean();

		if (is_null($this->layout->name)) {
			return (string) $content;
		}

		$layout = new Layout($this->azura, $this->layout->name, (string) $content, $this->layout->data ?? $this->data);

		return (string) $layout;
	}
}
