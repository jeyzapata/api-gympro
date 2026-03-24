<?php

declare(strict_types=1);

namespace App\Enums;

enum PlanSuscripcion: string
{
    case Trial = 'trial';
    case Basico = 'basico';
    case Pro = 'pro';
    case Enterprise = 'enterprise';
}
