<?php declare(strict_types=1);

namespace oscarpalmer\Azura;

mb_internal_encoding(Strings::ENCODING);

class Strings {
    private const ELLIPSIS = '&hellip;';

    private const JSON_OPTIONS = JSON_INVALID_UTF8_SUBSTITUTE | JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

    const ENCODING = 'UTF-8';

    function __construct() {}

    /**
     * Escape string by converting special characters
     *
     * @param string $value Original string
     * @return string Escaped string
     */
    public function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_HTML5 | ENT_QUOTES | ENT_SUBSTITUTE, self::ENCODING, false);
    }

    /**
     * Convert a value to JSON
     *
     * @param mixed $value Original value
     * @param bool $format Pretty print JSON?
     * @return string JSON representation for value
     */
    public function json(mixed $value, bool $format = false): string {
        $options = self::JSON_OPTIONS;

        if ($format === true) {
            $options |= JSON_PRETTY_PRINT;
        }

        return json_encode($value, $options);
    }

    /**
     * Get length of string
     *
     * @param string $value
     * @return string $length Length of string
     */
    public function length(string $value): int
    {
        return mb_strlen($value, self::ENCODING);
    }

    /**
     * Convert string to its lowercase variant
     *
     * @param string $value Original value
     * @return string Converted value
     */
    public function toLower(string $value): string
    {
        return mb_strtolower($value, self::ENCODING);
    }

    /**
     * Convert string to its uppercase variant
     *
     * @param string $value Original value
     * @return string Converted value
     */
    public function toUpper(string $value): string
    {
        return mb_strtoupper($value, self::ENCODING);
    }

    /**
     * Truncate string by length
     *
     * @param string $value Original string
     * @param int $length Maximum length
     * @param bool $ellipsis Append ellipsis character?
     * @return string Truncated string
     */
    public function truncate(string $value, int $length, bool $ellipsis = true): string
    {
        if ($this->length($value) <= $length) {
            return $value;
        }

        if ($ellipsis === false) {
            return mb_substr($value, 0, $length, SELF::ENCODING);
        }

        return mb_substr($value, 0, $length - 1, self::ENCODING) . SELF::ELLIPSIS;
    }
}
