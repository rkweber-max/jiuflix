<?php

namespace App\Enums;

enum Strips: string {
    case BRANCA = 'branca';
    case PRETA = 'preta';
    case AZUL = 'azul';


    public static function values(): array {
        return array_column(self::cases(), 'value');
    }
}