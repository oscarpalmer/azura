<?php

declare(strict_types=1);

namespace oscarpalmer\Azura\Templates;

use oscarpalmer\Azura\Azura;

mb_internal_encoding('UTF-8');

class Layout extends Template
{
    /**
     * @var string Content to render
     */
    public readonly string $content;

    /**
     * @param Azura $Azura Azura
     * @param string $name Layout name
     * @param string $content Content
     * @param mixed $data Data object
     */
    public function __construct(Azura $azura, string $name, string $content, mixed $data)
    {
        $this->initialize($azura, $name, $data);

        $this->content = trim($content);
    }
}
