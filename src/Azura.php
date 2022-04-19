<?php declare(strict_types=1);

namespace oscarpalmer\Azura;

use LogicException;

mb_internal_encoding('utf-8');

class Azura {
    const VERSION = '0.3.0';

    private string $directory;

    private string $extension;

    function __construct(string $directory, string $extension = null)
    {
        $this->setDirectory($directory);
        $this->setExtension($extension ?? 'phtml');
    }

    public function template(string $name, mixed $data = null): Template
    {
        return new Template($this, $this->getFile($name), $data);
    }

    private function getFile(string $name): string
    {
        if (mb_strlen($name, 'utf-8') === 0) {
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
        if (mb_strlen($extension, 'utf-8') === 0) {
            throw new LogicException("");
        }

        $extension = mb_substr($extension, 0, 1) === '.'
            ? ltrim($extension, '.')
            : $extension;

        $this->extension = ".{$extension}";
    }
}
