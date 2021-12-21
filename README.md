# CMS developed by Combind.ma

[![Latest Version on Packagist](https://img.shields.io/packagist/v/combindma/richcms.svg?style=flat-square)](https://packagist.org/packages/combindma/richcms)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/combindma/richcms/run-tests?label=tests)](https://github.com/combindma/richcms/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/combindma/richcms/Check%20&%20fix%20styling?label=code%20style)](https://github.com/combindma/richcms/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/combindma/richcms.svg?style=flat-square)](https://packagist.org/packages/combindma/richcms)

## Installation

You can install the package via composer:

```bash
composer require combindma/richcms
```

You must publish and run all needed migrations with:

```bash
php artisan vendor:publish --tag="richcms-migrations"
php artisan vendor:publish --tag="blog-migrations"
php artisan vendor:publish --tag="newsletter-migrations"
php artisan vendor:publish --tag="gallery-migrations"
php artisan vendor:publish --tag="redirector-migrations"
php artisan migrate
php artisan db:seed --class=Combindma\\Richcms\\Database\\Seeders\\RichcmsSeeder
```
This will create an admin user with these credentials:

email: a@a.a

password: pass

You must publish all the needed config files with:

```bash
php artisan vendor:publish --tag="richcms-config"
php artisan vendor:publish --tag="dashui-config"
php artisan vendor:publish --tag="backup-config"
php artisan vendor:publish --tag="redirector-config"
php artisan vendor:publish --provider="Artesaos\SEOTools\Providers\SEOToolsServiceProvider"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
php artisan vendor:publish --provider="Vinkla\Hashids\HashidsServiceProvider"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="richcms-views"
```

## Additional packages installation

```bash
composer require contentful/laravel
```

## Configuration

File config/richcms.php:

```php
return [
    'admin_url' => env('ADMIN_URL', 'path-to-dashbord'),
    'admin_email' => env('ADMIN_EMAIL', 'your-email-to-receive-notifications'),
];
```

File config/dashui.php:

```php
return [
    'layout' => 'layout2',  // theme layout
    'css_path' => '/assets/css/tailwind.css', //path to generated css style for tailwind
    'js_path' => '/assets/js/alpine.js', //path to generated alpine js file
];
```

File config/auth.php:

```php
return [
    //...
    'model' => Combindma\Richcms\Models\User::class,
    //...
```

File config/filesystems.php:

```php
return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'images' => [
            'driver' => 'local',
            'root' => storage_path('app/public/images'),
            'url' => env('APP_URL').'/storage/images',
            'visibility' => 'public',
        ],
        'uploads' => [
            'driver' => 'local',
            'root' => storage_path('app/public/uploads'),
            'url' => env('APP_URL').'/storage/uploads',
            'visibility' => 'public',
        ],
        'backups' => [
            'driver' => 'local',
            'root'   => storage_path('app/backups'), // that's where your backups are stored by default: storage/backups
        ],
        //...
    ],
];
```

File config/hashids.php:

```php
return [
    //...
    'main' => [
            'salt' => 'your-salt-string',
            'length' => 5,
            'alphabet' => 'abcdefghijklmnopqrstuvwxyz123456789',
        ],
    //...
];
```

File config/media-library.php:

```php
return [
    //...
    'queue_name' => 'images',
    'path_generator' => \Combindma\Richcms\Services\CustomPathGenerator::class,
    'default_loading_attribute_value' => 'lazy',
    //...
];
```

File App/Exceptions/Handler.php:

```php
protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }
        if ($request->is(config('richcms.admin_url')) || $request->is(config('richcms.admin_url').'/*')) {
            return redirect()->guest(route('richcms::login'));
        }
        return redirect()->guest('/');
    }

    //Log error with the url where error occured
    protected function context()
    {
        try {
            $context = array_filter([
                'url' => Request::fullUrl(),
                'input' => Request::all(),
                'userId' => Auth::id(),
            ]);
        } catch (Throwable $e) {
            $context = [];
        }

        return array_merge($context, parent::context());
    }
```

File App/Http/Kernel.php:

```php
protected $middleware = [
        //...
        \Combindma\Redirector\RedirectsMissingPages::class,
];
 protected $routeMiddleware = [
        //...
        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
];
```

File App/Http/Middleware/RedirectIfAuthenticated.php:

```php
public function handle(Request $request, Closure $next, ...$guards)
    {
        //$guards = empty($guards) ? [null] : $guards;

        if (Auth::guard()->check() && $request->is(config('richcms.admin_url').'/*') ) {
            return redirect(config('richcms.admin_url'));
        }
        if (Auth::guard()->check()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
```

File app/Http/Middleware/Authenticate.php:

```php
protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('richcms::login');
        }
    }
```

If Horizon is installed edit HorizonServiceProvider.php file:

```php
public function boot()
    {
        parent::boot();
        Horizon::routeMailNotificationsTo(config('richcms.admin_email'));
    }
protected function gate()
    {
        Gate::define('viewHorizon', function () {
            if (Auth::check()){
                return auth()->user()->hasRole(\Combindma\Richcms\Enums\Roles::Admin);
            }
            return false;
        });
    }
```

## Routes

Add this to your route file

```bash
Route::richcms();
```

## Usage

### Seo

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Combind](https://github.com/combindma)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
