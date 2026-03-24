<?php

declare(strict_types=1);

namespace App\Enums;

enum ObjetivoNutricional: string
{
    case PerdidaPeso = 'perdida_peso';
    case GananciaMuscular = 'ganancia_muscular';
    case Mantenimiento = 'mantenimiento';
    case Rendimiento = 'rendimiento';
    case Otro = 'otro';
}
