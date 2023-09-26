const zzz = [
    {
        location: "./",
        filename: ".env",
        templateLocalFile: "./src/assets/codeTemplates/backend/php_laravel/v10/.env.example",
        changes: [
            {
                // change database connection config
                typeOfChange: "string-replace",
                from: "~cb-app-servicename~",
                to: "stack.appName",
            },
        ],
    },
    {
        commands: {
            windows: ["composer install", "composer dump-autoload", "npm install", "php artisan storage:link", "php artisan cache:clear", "php artisan config:clear", "php artisan migrate"],
            unix: ["composer install", "php artisan cache:clear", "php artisan config:clear", "php artisan migrate"],
        },
    },
    {
        sqlCommand: [
            `CREATE TABLE 'exceptions' (
                'id' bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                'user_id' bigint(20) unsigned NOT NULL,
                'type' varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                'class' varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                'function' varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                'line' varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                'exception' text COLLATE utf8mb4_unicode_ci NOT NULL,
                'trace' text COLLATE utf8mb4_unicode_ci NOT NULL,
                'created_at' timestamp NULL DEFAULT NULL,
                'updated_at' timestamp NULL DEFAULT NULL,
                PRIMARY KEY ('id'),
                KEY 'exceptions_user_id_foreign' ('user_id'),
                CONSTRAINT 'exceptions_user_id_foreign' FOREIGN KEY ('user_id') REFERENCES 'users' ('id')
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            `
        ]
    }
];
