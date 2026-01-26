<?php

namespace App\Http\Controllers\Api;

use App\Models\Block;
use App\Models\Department;
use App\Models\Floor;
use App\Models\Site;

class UtilitiesController extends BaseController
{
    public function cities($country_id)
    {
        $cities = cities($country_id);
        return sendResponse($cities, 'Cities retrieved successfully.');

    }
}
