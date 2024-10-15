<?php

namespace App\Enum;

enum EquipmentState: string
{
    case NEUF = 'neuf';
    case BON_ETAT = 'bon_etat';
    case USE = 'use';
    case EN_REPARATION = 'en_reparation';
    case HORS_SERVICE = 'hors_service';
    case EN_LOCATION = 'en_location';
}