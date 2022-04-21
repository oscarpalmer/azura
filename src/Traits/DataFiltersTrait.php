<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Traits;

trait DataFiltersTrait {
    /**
     * Convert a value to JSON
     *
     * @param mixed $value Original value
     * @param bool $format Pretty print JSON?
     * @return string JSON representation for value
     */
    public function json(mixed $value, bool $format = false): string
    {
        $options = JSON_INVALID_UTF8_SUBSTITUTE | JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

        if ($format === true) {
            $options |= JSON_PRETTY_PRINT;
        }

        return json_encode($value, $options);
    }
}
