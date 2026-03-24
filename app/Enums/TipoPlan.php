<?php

declare(strict_types=1);

namespace App\Enums;

enum TipoPlan: string
{
    case Fijo = 'fijo';
    case PaseDia = 'pase_dia';
    case ClasesSueltas = 'clases_sueltas';
}
