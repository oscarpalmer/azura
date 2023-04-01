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

	protected $data;

	protected $file;

	protected $layoutData = null;

	protected string|null $layoutName = null;

	protected string $name;

	/**
	 * @param Azura $azura Azura
	 * @param string $name Template name
	 * @param $data Optional data object
	 */
	public function __construct(Azura $azura, string $name, $data = null)
	{
		$this->azura = $azura;
		$this->data = $data ?? new stdClass();

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
	 * @param $data Optional data object
	 */
	public function layout(string $name, $data = null): void
	{
		$this->layoutData = $data;
		$this->layoutName = $name;
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
	 * @param $data Optional data object
	 */
	public function include(string $name, $data = null): Template
	{
		return $this->azura->template($name, $data ?? $this->data);
	}

	private function getFile(Azura $azura, string $name): string
	{
		if (mb_strlen($name, $azura->getConfiguration()->getEncoding()) === 0) {
			throw new LogicException('');
		}

		$extension = str_contains($name, '.')
			? ''
			: $azura->getConfiguration()->getExtension();

		$filename = "{$azura->getConfiguration()->getDirectory()}/{$name}.{$extension}";

		if (! is_file($filename)) {
			throw new LogicException('');
		}

		return $filename;
	}

	private function renderFile(): string
	{
		ob_start();

		include $this->file;

		$content = ob_get_clean();

		if (is_null($this->layoutName)) {
			return (string) $content;
		}

		$layout = new Layout($this->azura, $this->layoutName, (string) $content, $this->layoutData ?? $this->data);

		return (string) $layout;
	}
}
