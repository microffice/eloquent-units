<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Database settings
    |--------------------------------------------------------------------------
    |
    | The name of the table to create in the database
    |
    */
    'table_name' => env('MO_UNITS_TABLE_NAME', 'units'),

    //'handler' => env('MO_UNITS_handler', 'Microffice\EloquentUnits\EloquentUnitHandler'),
    'handler' => env('MO_UNITS_handler', 'Microffice\EloquentUnits\EloquentUnitHandler'),

);
