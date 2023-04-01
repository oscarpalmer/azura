<?php

declare(strict_types=1);

namespace oscarpalmer\Azura\Filters;

trait StringFilters
{
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
}
