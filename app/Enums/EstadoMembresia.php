<?php

declare(strict_types=1);

namespace App\Enums;

enum EstadoMembresia: string
{
    case Activa = 'activa';
    case Vencida = 'vencida';
    case Congelada = 'congelada';
    case Cancelada = 'cancelada';
    case PendientePago = 'pendiente_pago';
}
