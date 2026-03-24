<?php

declare(strict_types=1);

namespace App\Enums;

enum EstadoReserva: string
{
    case Reservada = 'reservada';
    case Confirmada = 'confirmada';
    case Asistio = 'asistio';
    case Ausente = 'ausente';
    case Cancelada = 'cancelada';
}
