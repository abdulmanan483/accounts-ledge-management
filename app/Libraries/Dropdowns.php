<?php


use App\Models\{Province, State, City, Role};
use Nnjeim\World\Models\Country;

/**
 * Get listing of a resource.
 */
function roles()
{
    return Role::pluck('name','id')->all();
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
    return $dropdown == true ? Country::pluck("name","id") : Country::get();
}
function country($country_id)
{
    return Country::where('id',$country_id)->first();
}


/**
 * Get listing of a resource.
 */
function states($dropdown = true,$country_id = null)
{
    if($country_id){
        return $dropdown == true ? State::where('country_id',$country_id)->pluck("name","id") : State::where('country_id',$country_id)->get();
    }
    return $dropdown == true ? State::pluck("name","id") : State::get();
}
function state($state_id)
{
    return State::where('id',$state_id)->first();
}
/**
 * Get listing of a resource.
 */
function cities($dropdown = true)
{
    return $dropdown == true ? City::pluck("name","id") : City::get();
}
