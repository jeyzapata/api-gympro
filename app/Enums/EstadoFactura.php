<?php

declare(strict_types=1);

namespace App\Enums;

enum EstadoFactura: string
{
    case Pendiente = 'pendiente';
    case Pagada = 'pagada';
    case Vencida = 'vencida';
    case Anulada = 'anulada';
}
