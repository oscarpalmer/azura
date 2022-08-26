<?php

declare(strict_types=1);

namespace oscarpalmer\Azura\Filters;

trait StringFilters
{
	/**
	 * Capitalize string
	 *
	 * @param string $value String to capitalize
	 */
	public function capitalize(string $value): string
	{
		$length = $this->length($value);

		if ($length < 2) {
			return $this->upper($value);
		}

		$first = mb_substr($value, 0, 1, $this->azura->getConfiguration()->getEncoding());
		$rest = mb_substr($value, 1, $length, $this->azura->getConfiguration()->getEncoding());

		return $this->upper($first) . $rest;
	}

	/**
	 * Escape string by converting special characters
	 *
	 * @param string $value Original string
	 */
	public function escape(string $value): string
	{
		return htmlspecialchars($value, ENT_HTML5 | ENT_QUOTES | ENT_SUBSTITUTE, $this->azura->getConfiguration()->getEncoding(), false);
	}

	/**
	 * Get length of string
	 *
	 * @param string $value String to measure
	 */
	public function length(string $value): int
	{
		return mb_strlen($value, $this->azura->getConfiguration()->getEncoding());
	}

	/**
	 * Convert string to its lowercase variant
	 *
	 * @param string $value Original value
	 */
	public function lower(string $value): string
	{
		return mb_strtolower($value, $this->azura->getConfiguration()->getEncoding());
	}

	/**
	 * Convert string to its title-cased variant
	 *
	 * @param string $value String to convert
	 */
	public function title(string $value): string
	{
		if ($this->length($value) < 2) {
			return $this->upper($value);
		}

		return mb_convert_case($value, \MB_CASE_TITLE, $this->azura->getConfiguration()->getEncoding());
	}

	/**
	 * Truncate string by length
	 *
	 * @param string $value Original string
	 * @param int $length Maximum length
	 * @param bool|string $ellipsis Append ellipsis character?
	 */
	public function truncate(string $value, int $length, bool|string $ellipsis = true): string
	{
		if ($this->length($value) <= $length) {
			return $value;
		}

		if ($ellipsis === false) {
			return mb_substr($value, 0, $length, $this->azura->getConfiguration()->getEncoding());
		}

		$ellipsis = is_string($ellipsis)
			? $ellipsis
			: '&hellip;';

		return mb_substr($value, 0, $length - 1, $this->azura->getConfiguration()->getEncoding()) . $ellipsis;
	}

	/**
	 * Convert string to its uppercase variant
	 *
	 * @param string $value Original value
	 */
	public function upper(string $value): string
	{
		return mb_strtoupper($value, $this->azura->getConfiguration()->getEncoding());
	}
}
