<?php

namespace App\Enums\Media;
use App\Traits\Enums;

enum MediaType: string
{
    use Enums;
    case ASSET_AUDIT = 'asset_audit';
    case MEDIA = 'media';
}
