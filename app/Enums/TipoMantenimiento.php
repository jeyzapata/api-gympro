<?php

declare(strict_types=1);

namespace App\Enums;

enum TipoMantenimiento: string
{
    case Preventivo = 'preventivo';
    case Correctivo = 'correctivo';
    case Revision = 'revision';
}
