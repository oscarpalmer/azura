<?php declare(strict_types=1);

namespace oscarpalmer\Azura;

use oscarpalmer\Azura\Traits\DataFiltersTrait;
use oscarpalmer\Azura\Traits\StringFiltersTrait;

mb_internal_encoding('UTF-8');

class Filters
{
    use DataFiltersTrait;
    use StringFiltersTrait;

    function __construct(private readonly Azura $azura) {}
}
