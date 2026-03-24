<?php

declare(strict_types=1);

namespace App\Enums;

enum EstadoTurnoClase: string
{
    case Programado = 'programado';
    case EnCurso = 'en_curso';
    case Finalizado = 'finalizado';
    case Cancelado = 'cancelado';
}
