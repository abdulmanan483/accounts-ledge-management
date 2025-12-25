<?php

namespace App\Services;

use Jenssegers\Agent\Agent;

class DeviceService
{
    protected $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Check if the device is mobile.
     *
     * @return bool
     */
    public function isMobile()
    {
        return $this->agent->isMobile();
    }

    /**
     * Check if the device is a tablet.
     *
     * @return bool
     */
    public function isTablet()
    {
        return $this->agent->isTablet();
    }
}
