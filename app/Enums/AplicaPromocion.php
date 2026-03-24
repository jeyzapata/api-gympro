<?php

declare(strict_types=1);

namespace App\Enums;

enum AplicaPromocion: string
{
    case Todos = 'todos';
    case PlanEspecifico = 'plan_especifico';
    case PrimeraMembresia = 'primera_membresia';
}
