<?php


use App\Models\{Province, State, City, Role};


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
function provinces()
{
    return Province::pluck("name","id");
}

/**
 * Get listing of a resource.
 */
function states($dropdown = true)
{
    return $dropdown == true ? State::pluck("name","id") : State::get();
}

/**
 * Get listing of a resource.
 */
function cities($dropdown = true)
{
    return $dropdown == true ? City::pluck("name","id") : City::get();
}
