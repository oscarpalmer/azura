<?php declare(strict_types=1);

namespace oscarpalmer\Azura;

use LogicException;

mb_internal_encoding(Strings::ENCODING);

class Azura {
    /**
     * @var string Version number
     */
    const VERSION = '0.4.0';

    private readonly string $directory;

    private readonly string $extension;

    /**
     * @var Strings String manipulation helper
     */
    public readonly Strings $strings;

    /**
     * @param string $directory Base directory
     * @param string $extension Default extensions
     */
    function __construct(string $directory, string $extension = null)
    {
        $this->setDirectory($directory);
        $this->setExtension($extension ?? 'phtml');

        $this->strings = new Strings;
    }

    /**
     * @param string $name Name of template
     * @param mixed $data Optional data
     * @return Template A new template
     */
    public function template(string $name, mixed $data = null): Template
    {
        return new Template($this, $this->getFile($name), $data);
    }

    private function getFile(string $name): string
    {
        if (mb_strlen($name, Strings::ENCODING) === 0) {
            throw new LogicException("");
        }

        $extension = str_contains($name, '.')
            ? ''
            : $this->extension;

        $filename = "{$this->directory}/{$name}{$extension}";

        if (!is_file($filename)) {
            throw new LogicException("");
        }

        return $filename;
    }

    private function setDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            throw new LogicException("");
        }

        $this->directory = $directory;
    }

    private function setExtension(string $extension): void
    {
        if (mb_strlen($extension, Strings::ENCODING) === 0) {
            throw new LogicException("");
        }

        $extension = mb_substr($extension, 0, 1) === '.'
            ? ltrim($extension, '.')
            : $extension;

        $this->extension = ".{$extension}";
    }
}
