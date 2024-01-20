<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Package driver
    |--------------------------------------------------------------------------
    |
    | The package supports different drivers for translation management.
    |
    | Supported: "file", "database"
    |
    */
    'driver' => 'file',

    /*
    |--------------------------------------------------------------------------
    | Route group configuration
    |--------------------------------------------------------------------------
    |
    | The package ships with routes to handle language management. Update the
    | configuration here to configure the routes with your preferred group options.
    |
    */
    'route_group_config' => [
        'middleware' => ['web','auth'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Translation methods
    |--------------------------------------------------------------------------
    |
    | Update this array to tell the package which methods it should look for
    | when finding missing translations.
    |
    */
    'translation_methods' => ['trans', '__'],

    /*
    |--------------------------------------------------------------------------
    | Scan paths
    |--------------------------------------------------------------------------
    |
    | Update this array to tell the package which directories to scan when
    | looking for missing translations.
    |
    */
    'scan_paths' => [app_path(), resource_path()],

    /*
    |--------------------------------------------------------------------------
    | UI URL
    |--------------------------------------------------------------------------
    |
    | Define the URL used to access the language management too.
    |
    */
    'ui_url' => 'languages',

    /*
    |--------------------------------------------------------------------------
    | Database settings
    |--------------------------------------------------------------------------
    |
    | Define the settings for the database driver here.
    |
    */
    'database' => [

        'connection' => '',

        'languages_table' => 'languages',

        'translations_table' => 'translations',
    ],

    /* scan_mode = file , directory, copyFile, copyDirectory */
    'scan_groups'=> [      
        'system'=>[
            '0'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'shared'.DIRECTORY_SEPARATOR.'variables.blade.php',
                'type'=>'view',
                'scan_mode'=>'file'
            ],
            '1'=> [
                'path'=>app_path().DIRECTORY_SEPARATOR.'Helpers',
                'type'=>'helper',
                'scan_mode'=>'directory'
            ],         
            '2'=> [
                'path'=>app_path().DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'Home.php',
                'type'=>'controller',
                'scan_mode'=>'file'
            ],
            '3'=> [
                'path'=>app_path().DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'UpdateSystem.php',
                'type'=>'controller',
                'scan_mode'=>'file'
            ],
            '4'=> [
                'path'=>app_path().DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'Multilanguage.php',
                'type'=>'controller',
                'scan_mode'=>'file'
            ],            
            '5'=> [
                'path'=>app_path().DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'Settings.php',
                'type'=>'controller',
                'scan_mode'=>'file'
            ],
            '6'=> [
                'path'=>app_path().DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'Auth',
                'type'=>'controller',
                'scan_mode'=>'directory'
            ],
            '7'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'auth',
                'type'=>'view',
                'scan_mode'=>'directory'
            ],
            '8'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'admin',
                'type'=>'view',
                'scan_mode'=>'directory'
            ],
            '11'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'leads',
                'type'=>'view',
                'scan_mode'=>'directory'
            ],
            '12'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'guest.blade.php',
                'type'=>'view',
                'scan_mode'=>'file'
            ],
            '12'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'auth.blade.php',
                'type'=>'view',
                'scan_mode'=>'file'
            ],
            '13'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'error.blade.php',
                'type'=>'view',
                'scan_mode'=>'file'
            ],
            '14'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'shared'.DIRECTORY_SEPARATOR.'limit-check-error.blade.php',
                'type'=>'view',
                'scan_mode'=>'file'
            ]
        ],
        'dashboard'=>[
            '0'=> [
                'path'=>app_path().DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'Dashboard.php',
                'type'=>'controller',
                'scan_mode'=>'file'
            ],
            '1'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'dashboard.blade.php',
                'type'=>'view',
                'scan_mode'=>'file'
            ]
        ],
        'landing'=>[
            '2'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'landing',
                'type'=>'view',
                'scan_mode'=>'directory'
            ],
            '3'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'domain',
                'type'=>'view',
                'scan_mode'=>'directory'
            ],
            '4'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'site.blade.php',
                'type'=>'view',
                'scan_mode'=>'file'
            ],
            '5'=> [
                'path'=>resource_path('views').DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'gdpr.blade.php',
                'type'=>'view',
                'scan_mode'=>'file'
            ]
        ]
    ]
];
