<?php

declare(strict_types=1);

namespace App\Enums;

enum EstadoMantenimiento: string
{
    case Programado = 'programado';
    case EnProgreso = 'en_progreso';
    case Completado = 'completado';
    case Cancelado = 'cancelado';
}
