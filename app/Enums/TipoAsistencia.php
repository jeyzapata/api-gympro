<?php

declare(strict_types=1);

namespace App\Enums;

enum TipoAsistencia: string
{
    case Clase = 'clase';
    case AccesoLibre = 'acceso_libre';
}
