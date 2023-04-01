<?php

declare(strict_types=1);

namespace oscarpalmer\Azura;

use oscarpalmer\Azura\Filters\Filter;
use oscarpalmer\Azura\Templates\Template;

final class Azura
{
	public const VERSION = '0.8.0';

	private Configuration $configuration;

	private Filter $filter;

	/**
	 * @param Configuration $configuration Configuration
	 */
	public function __construct(?Configuration $configuration = null)
	{
		$this->configuration = $configuration ?? new Configuration();

		$this->filter = new Filter($this);
	}

	/**
	 * Get configuration object
	 */
	public function getConfiguration(): Configuration
	{
		return $this->configuration;
	}

	/**
	 * Get filter helper
	 */
	public function getFilter(): Filter
	{
		return $this->filter;
	}

	/**
	 * Create a template
	 *
	 * @param string $name Name of template file
	 * @param $data Optional data object
	 */
	public function template(string $name, $data = null): Template
	{
		return new Template($this, $name, $data);
	}
}
