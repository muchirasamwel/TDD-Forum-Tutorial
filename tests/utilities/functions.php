<?php
function create($class, $attributes = [],$items=null)
{
    return factory($class,$items)->create($attributes);
}

function make($class, $attributes = [],$items=null)
{
    return factory($class,$items)->make($attributes);
}
