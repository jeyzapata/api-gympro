<?php

declare(strict_types=1);

namespace App\Enums;

enum TipoDescuento: string
{
    case Porcentaje = 'porcentaje';
    case MontoFijo = 'monto_fijo';
    case MesesGratis = 'meses_gratis';
}
