<?php declare(strict_types=1);

namespace oscarpalmer\Azura;

use stdClass;

mb_internal_encoding('utf-8');

class Template {
    public readonly Azura $azura;

    public readonly mixed $data;

    public readonly string $file;

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

    private function renderFile(): string
    {
        ob_start();

        include($this->file);

        return ob_get_clean();
    }
}
