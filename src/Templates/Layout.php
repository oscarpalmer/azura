<?php

declare(strict_types=1);

namespace oscarpalmer\Azura\Templates;

use oscarpalmer\Azura\Azura;

final class Layout extends Template
{
	private readonly string $content;

	/**
	 * @param Azura $azura Azura
	 * @param string $name Layout name
	 * @param string $content Content
	 * @param mixed $data Data object
	 */
	public function __construct(Azura $azura, string $name, string $content, mixed $data)
	{
		parent::__construct($azura, $name, $data);

		$this->content = trim($content);
	}

	/**
	 * Get content for layout
	 */
	public function getContent(): string
	{
		return $this->content;
	}
}
