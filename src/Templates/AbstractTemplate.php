<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Templates;

use LogicException;
use stdClass;
use oscarpalmer\Azura\Azura;
use oscarpalmer\Azura\Filters;

mb_internal_encoding('UTF-8');

abstract class AbstractTemplate {
    protected readonly Azura $azura;

    protected readonly mixed $data;

    protected readonly string $file;

    protected mixed $layout_data = null;

    protected string|null $layout_name = null;

    /**
     * @var Filters Filters for data
     */
    public readonly Filters $filters;

    protected function __construct() {}

    /**
     * Render template
     *
     * @return string Rendered template
     */
    public function __toString(): string
    {
        return $this->renderFile();
    }

    /**
     * Render template
     *
     * @return string Rendered template
     */
    public function render(): void
    {
        echo($this->renderFile());
    }

    /**
     * Include (and render) a template
     *
     * @param string $name Name of template
     * @param mixed $data Optional data object
     * @return Template Template
     */
    public function include(string $name, mixed $data = null): Template
    {
        return $this->azura->template($name, $data ?? $this->data);
    }

    protected function initialize(Azura $azura, string $name, mixed $data): void
    {
        $this->file = $this->getFile($azura, $name);

        $this->azura = $azura;
        $this->data = $data ?? new stdClass;
        $this->filters = $azura->filters;
    }

    private function getFile(Azura $azura, string $name): string
    {
        if (mb_strlen($name, $azura->configuration->encoding) === 0) {
            throw new LogicException("");
        }

        $extension = str_contains($name, '.')
            ? ''
            : $azura->configuration->extension;

        $filename = "{$azura->configuration->directory}/{$name}{$extension}";

        if (!is_file($filename)) {
            throw new LogicException("");
        }

        return $filename;
    }

    private function renderFile(): string
    {
        ob_start();

        include($this->file);

        $content = ob_get_clean();

        if (is_null($this->layout_name)) {
            return $content;
        }

        $layout = new Layout($this->azura, $this->layout_name, $content, $this->layout_data ?? $this->data);

        return (string) $layout;
    }
}
