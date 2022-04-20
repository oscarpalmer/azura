<?php declare(strict_types=1);

namespace oscarpalmer\Azura;

use stdClass;

mb_internal_encoding('utf-8');

class Template {
    private readonly Azura $azura;

    private readonly mixed $data;

    private readonly string $file;

    public readonly Strings $strings;

    /**
     * @param Azura $Azura Azura
     * @param string $file Filename
     * @param mixed $data Data object
     */
    function __construct(Azura $azura, string $file, mixed $data = null)
    {
        $this->azura = $azura;
        $this->data = $data ?? new stdClass;
        $this->file = $file;
        $this->strings = $azura->strings;
    }

    /**
     * Render template
     *
     * @return string Rendered template
     */
    function __toString(): string
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
    protected function include(string $name, mixed $data = null): Template
    {
        return $this->azura->template($name, $data ?? $this->data);
    }

    private function renderFile(): string
    {
        ob_start();

        include($this->file);

        return ob_get_clean();
    }
}
