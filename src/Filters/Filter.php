<?php

declare(strict_types=1);

namespace oscarpalmer\Azura\Filters;

use oscarpalmer\Azura\Azura;

mb_internal_encoding('UTF-8');

class Filter
{
    use DataFilters;
    use StringFilters;

    public function __construct(private readonly Azura $azura)
    {
    }
}
