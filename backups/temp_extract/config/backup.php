<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Drive Backup Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google Drive backup functionality
    |
    */

    'google_drive_client_id' => env('GOOGLE_DRIVE_CLIENT_ID'),
    'google_drive_client_secret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
    'google_drive_redirect_uri' => env('GOOGLE_DRIVE_REDIRECT_URI'),
    'google_drive_refresh_token' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
    'google_drive_access_token' => env('GOOGLE_DRIVE_ACCESS_TOKEN'),
    'google_drive_backup_folder' => env('GOOGLE_DRIVE_BACKUP_FOLDER', 'SJ Fashion Hub Backups'),

    /*
    |--------------------------------------------------------------------------
    | Backup Schedule Configuration
    |--------------------------------------------------------------------------
    */

    'schedule_enabled' => env('BACKUP_SCHEDULE_ENABLED', false),
    'schedule_time' => env('BACKUP_SCHEDULE_TIME', '02:00'),
    'retention_days' => env('BACKUP_RETENTION_DAYS', 7),

    /*
    |--------------------------------------------------------------------------
    | Backup Paths
    |--------------------------------------------------------------------------
    */

    'backup_paths' => [
        'app',
        'config',
        'database',
        'public',
        'resources',
        'routes',
        'storage/app',
        '.env',
        'composer.json',
        'composer.lock',
        'package.json',
    ],

    /*
    |--------------------------------------------------------------------------
    | Exclude Paths
    |--------------------------------------------------------------------------
    */

    'exclude_paths' => [
        'storage/logs',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'node_modules',
        'vendor',
        '.git',
        '.gitignore',
        'bootstrap/cache',
    ],
];
