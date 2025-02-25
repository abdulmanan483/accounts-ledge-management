<?php

use App\Models\Block;
use App\Models\Department;
use App\Models\Floor;
use App\Models\Role;
use App\Models\Site;
// use App\Models\State;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

/**
 * Get listing of a resource.
 */
function roles()
{
    return Role::pluck('name', 'id')->all();
}

/**
 * Get listing of a resource.
 */
// function provinces()
// {
//     return Province::pluck("name","id");
// }
/**
 * Get listing of a resource.
 */
function countries($dropdown = true)
{
    return $dropdown == true ? Country::pluck("name", "id") : Country::get();
}
function country($country_id)
{
    return Country::where('id', $country_id)->first();
}

/**
 * Get listing of a resource.
 */
function states($dropdown = true, $country_id = null)
{
    if ($country_id) {
        return $dropdown == true ? State::where('country_id', $country_id)->pluck("name", "id") : State::where('country_id', $country_id)->get();
    }
    return $dropdown == true ? State::pluck("name", "id") : State::get();
}
function state($state_id)
{
    return State::where('id', $state_id)->first();
}
/**
 * Get listing of a resource with cache and cursor.
 */
function cities($dropdown = true, $groupByState = false)
{
    $cacheKey = $dropdown
        ? ($groupByState ? 'cities_grouped_by_state' : 'cities_dropdown')
        : 'cities_full_list';

    return cache()->remember($cacheKey, now()->addHours(1), function () use ($dropdown, $groupByState) {
        $query = City::with('state')->where('country_id', settings('default_country_id'));

        if ($groupByState) {
            // Group cities by their state name for dropdown
            return $query->get()
                ->groupBy(fn($city) => $city->state->name ?? 'Unknown State')
                ->map(fn($group) => $group->pluck('name', 'id'))
                ->toArray();
        }

        return $dropdown
            ? $query->pluck('name', 'id') // Simple key-value pair for dropdown
            : $query->cursor();           // Efficiently iterate over large datasets
    });
}


/**
 * Get listing of a resource.
 */
function sites($dropdown = true)
{
    return $dropdown == true ? Site::pluck("name", "id") : Site::get();
}
/**
 * Get listing of a resource.
 */
function floors($dropdown = true)
{
    return $dropdown == true ? Floor::pluck("name", "id") : Floor::get();
}

/**
 * Get listing of a resource.
 */
function blocks($dropdown = true)
{
    return $dropdown == true ? Block::pluck("name", "id") : Block::get();
}

/**
 * Get listing of a resource.
 */
function departments($dropdown = true)
{
    return $dropdown == true ? Department::pluck("name", "id") : Department::get();
}
