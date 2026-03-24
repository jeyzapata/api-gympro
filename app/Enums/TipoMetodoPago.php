<?php

declare(strict_types=1);

namespace App\Enums;

enum TipoMetodoPago: string
{
    case Efectivo = 'efectivo';
    case Digital = 'digital';
    case Tarjeta = 'tarjeta';
    case Otro = 'otro';
}
