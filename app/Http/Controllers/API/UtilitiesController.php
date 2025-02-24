<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Department;
use App\Models\Floor;
use App\Models\Site;
use Illuminate\Http\Request;

class UtilitiesController extends BaseController
{
    public function getSites(){
        $sites = Site::all();
        return $this->sendResponse($sites, 'Sites retrieved successfully.');
    }
    public function getFloors(){
        $floors = Floor::all();
        return $this->sendResponse($floors, 'Floors retrieved successfully.');
    }
    public function getBlocks(){
        $blocks = Block::all();
        return $this->sendResponse($blocks, 'Blocks retrieved successfully.');
    }
    public function getDepartments(){
        $departments = Department::all();
        return $this->sendResponse($departments, 'Departments retrieved successfully.');
    }
}
