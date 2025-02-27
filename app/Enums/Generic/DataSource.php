<?php

namespace App\Enums\Generic;

enum DataSource: string
{
    case SAP = 'sap';
    case CUSTOM = 'custom';
    case PACKAGE = 'package';
}
