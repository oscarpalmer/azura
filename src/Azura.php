<?php

namespace oscarpalmer\Azura;

class Azura {
    const VERSION = '0.2.0';

    public function template(string $file, mixed $data = null): Template
    {
        if (is_file($file) === false) {
            throw new \LogicException("'{$file}' is not a template file");
        }

        return new Template($this, $file, $data);
    }
}
