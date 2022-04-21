<?php declare(strict_types=1);

namespace oscarpalmer\Azura;

use LogicException;
use oscarpalmer\Azura\Templates\Template;

mb_internal_encoding('UTF-8');

class Azura {
    /**
     * @var string Version number
     */
    const VERSION = '0.6.0';

    /**
     * @var Configuration Configuration options
     */
    public readonly Configuration $configuration;

    /**
     * @var Filters Filters for data
     */
    public readonly Filters $filters;

    /**
     * @param Configuration $configuration Configuration
     */
    function __construct(Configuration $configuration = new Configuration)
    {
        $this->configuration = $configuration;

        $this->validateDirectory();
        $this->validateAndSetExtension();

        $this->filters = new Filters($this);
    }

    /**
     * Include (and render) a template
     *
     * @param string $name Name of template
     * @param mixed $data Optional data object
     * @return Template Template
     */
    public function template(string $name, mixed $data = null): Template
    {
        return new Template($this, $name, $data);
    }

    private function validateDirectory(): void
    {
        if (!is_dir($this->configuration->directory)) {
            throw new LogicException("");
        }
    }

    private function validateAndSetExtension(): void
    {
        $extension = $this->configuration->extension;

        if (mb_strlen($extension, $this->configuration->encoding) === 0) {
            throw new LogicException("");
        }

        $extension = mb_substr($extension, 0, 1) === '.'
            ? ltrim($extension, '.')
            : $extension;

        $this->configuration->extension = ".{$extension}";
    }
}
