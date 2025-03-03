<?php

namespace App\Http\Controllers\Api;

use App\Models\Block;
use App\Models\Department;
use App\Models\Floor;
use App\Models\Site;

class UtilitiesController extends BaseController
{
    public function getSites(){
        $sites = Site::all();
        return sendResponse($sites, 'Sites retrieved successfully.');
    }
    public function getFloors(){
        $floors = Floor::all();
        return sendResponse($floors, 'Floors retrieved successfully.');
    }
    public function getBlocks(){
        $blocks = Block::all();
        return sendResponse($blocks, 'Blocks retrieved successfully.');
    }
    public function getDepartments(){
        $departments = Department::all();
        return sendResponse($departments, 'Departments retrieved successfully.');
    }
}
