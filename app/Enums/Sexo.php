<?php

declare(strict_types=1);

namespace App\Enums;

enum Sexo: string
{
    case Masculino = 'masculino';
    case Femenino = 'femenino';
    case Otro = 'otro';
}
