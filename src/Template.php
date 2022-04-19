<?php

namespace oscarpalmer\Azura;

use stdClass;

class Template {
    private Azura $azura;

    private stdClass $data;

    private string $file;

    function __construct(Azura $azura, string $file, mixed $data = null) {
        $this->azura = $azura;
        $this->data = $data ?? new stdClass;
        $this->file = $file;
    }

    function __toString(): string {
        return $this->renderFile();
    }

    public function render(): void {
        echo($this->renderFile());
    }

    private function renderFile(): string {
        ob_start();

        include($this->file);

        return ob_get_clean();
    }
}
