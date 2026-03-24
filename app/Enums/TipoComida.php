<?php

declare(strict_types=1);

namespace App\Enums;

enum TipoComida: string
{
    case Desayuno = 'desayuno';
    case Almuerzo = 'almuerzo';
    case Merienda = 'merienda';
    case Cena = 'cena';
    case Colacion = 'colacion';
}
