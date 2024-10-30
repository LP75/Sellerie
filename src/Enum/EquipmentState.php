<?php

namespace App\Enum;

enum EquipmentState: string
{
    case NEUF = 'Neuf';
    case BON_ETAT = 'Bon état';
    case USE = 'Usé';
    case EN_REPARATION = 'En réparation';
    case HORS_SERVICE = 'Hors service';
    case EN_LOCATION = 'En location';

    public function getState(): string
    {
        return match($this) {
            self::NEUF => 'Neuf',
            self::BON_ETAT => 'Bon état',
            self::USE => 'Usé',
            self::EN_REPARATION => 'En réparation',
            self::HORS_SERVICE => 'Hors service',
            self::EN_LOCATION => 'En location',
        };
    }
}