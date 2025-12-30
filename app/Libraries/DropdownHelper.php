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
function cities(
    int $country_id,
    bool $dropdown = true,
    bool $groupByState = false,
) {

    $cacheKeyParts = [
        'country' => $country_id,
        'type'    => $dropdown ? 'dropdown' : 'full',
        'group'   => $groupByState ? 'state' : 'none',
    ];

    $cacheKey = 'cities_' . implode('_', $cacheKeyParts);

    return cache()->remember($cacheKey, now()->addHours(1), function () use ($country_id, $dropdown, $groupByState) {
        $query = City::with('state')
            ->where('country_id', $country_id);

        if ($groupByState) {
            return $query->get()
                ->groupBy(fn ($city) => $city->state->name ?? 'Unknown State')
                ->map(fn ($group) => $group->pluck('name', 'id'))
                ->toArray();
        }

        return $dropdown
            ? $query->pluck('name', 'id')
            : $query->cursor();
    });
}