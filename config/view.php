<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

    /*
     |--------------------------------------------------------------------------
     | Blade View Modification Checking
     |--------------------------------------------------------------------------
     |
     | On every request the framework will check to see if a view has expired
     | to determine if it needs to be recompiled. If you are in production
     | and precompiling views this feature may be disabled to save time.
     |
     */

    'expires' => env('VIEW_CHECK_EXPIRATION', true),

    'job_types' => [
        0 => "Member",
        1 => "Cash",
        2 => "Credit",
    ],
    'job_status' => [
        0 => "Added",
        1 => "Assigned",
        2 => "Completed",
        3 => "Cancelled",
        4 => "Not Done",
    ],
    'payment_status' => [
        0 => "Not Completed",
        1 => "Batch Created",
        2 => "Completed",
    ],
    'log_keys' => [
        'LOGIN' => "User Login",
        'ADD_JOB' => "Job added.",
        'EDIT_JOB' => "Job updated.",
        'DELETE_JOB' => "Job deleted.",
        'ASSIGN_JOB' => "Job assigned to driver.",
        'COMPLETE_JOB' => "Job completed.",
        'CANCELLED_JOB' => "Job Cancelled.",
        'NOT_DONE_JOB' => "Job status changed to not done.",
    ]
];
