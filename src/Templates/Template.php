<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Templates;

use oscarpalmer\Azura\Azura;

mb_internal_encoding('UTF-8');

class Template extends AbstractTemplate {
    /**
     * @param Azura $Azura Azura
     * @param string $name Template name
     * @param mixed $data Optional data object
     */
    function __construct(Azura $azura, string $file, mixed $data = null)
    {
        $this->initialize($azura, $file, $data);
    }

    /**
     * Define a layout for this template
     *
     * @param string $name Name of layout
     * @param mixed $data Optional data object
     */
    public function layout(string $name, mixed $data = null): void
    {
        $this->layout_data = $data;
        $this->layout_name = $name;
    }
}
