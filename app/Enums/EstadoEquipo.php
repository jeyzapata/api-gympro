<?php

declare(strict_types=1);

namespace App\Enums;

enum EstadoEquipo: string
{
    case Operativo = 'operativo';
    case EnMantenimiento = 'en_mantenimiento';
    case FueraDeServicio = 'fuera_de_servicio';
    case DadoDeBaja = 'dado_de_baja';
}
