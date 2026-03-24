<?php

declare(strict_types=1);

namespace App\Enums;

enum TipoNotificacion: string
{
    case Membresia = 'membresia';
    case Pago = 'pago';
    case Clase = 'clase';
    case Mantenimiento = 'mantenimiento';
    case Promocion = 'promocion';
    case General = 'general';
}
