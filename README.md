API tester for open-admin
============================

[![StyleCI](https://styleci.io/repos/457879925/shield?branch=main)](https://styleci.io/repos/99563385)
[![Packagist](https://img.shields.io/github/license/open-admin-org/api-tester.svg?maxAge=2592000&style=flat-square&color=brightgreen)](https://packagist.org/packages/open-admin-ext/api-tester)
[![Total Downloads](https://img.shields.io/packagist/dt/open-admin-ext/api-tester.svg?style=flat-square&color=brightgreen)](https://packagist.org/packages/open-admin-admin-ext/api-tester)
[![Pull request welcome](https://img.shields.io/badge/pr-welcome-green.svg?style=flat-square&color=brightgreen)]()

[Documentation](http://open-admin.org/docs/en/extension-api-tester)

## Screenshot

![extention-api-tester](https://user-images.githubusercontent.com/86517067/153463990-bd59e3ac-bc88-4858-adac-2714cc08e705.png)


## Installation

```
$ composer require open-admin-ext/api-tester

$ php artisan vendor:publish --tag=api-tester

```

Then last run flowing command to import menu and permission:

```
$ php artisan admin:import api-tester
```

Finally open `http://localhost/admin/api-tester`.

## Configuration

`api-tester` supports 3 configuration, open `config/admin.php` find `extensions`:
```php

    'extensions' => [

        'api-tester' => [

            // route prefix for APIs
            'prefix' => 'api',

            // auth guard for api
            'guard'  => 'api',

            // If you are not using the default user model as the authentication model, set it up
            'user_retriever' => function ($id) {
                return \App\User::find($id);
            },
        ]
    ]

```

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
