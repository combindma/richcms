<?php

namespace Combindma\Richcms\Tests;

use Combindma\Richcms\Http\Controllers\LoginController;
use Combindma\Richcms\Http\Controllers\ProfileController;
use Combindma\Richcms\Http\Controllers\UserController;
use Combindma\Richcms\Models\User;
use Combindma\Richcms\RichcmsServiceProvider;
use Elegant\Sanitizer\Laravel\SanitizerServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Propaganistas\LaravelDisposableEmail\DisposableEmailServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Combindma\\Richcms\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            RichcmsServiceProvider::class,
            SanitizerServiceProvider::class,
            DisposableEmailServiceProvider::class,
            PermissionServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //Schema::dropAllTables(); //run MYSQL server by this command: brew services start mysql

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->setLaravelPermissions($app);

        $migration = include __DIR__ . '/../database/migrations/create_richcms_table.php.stub';
        $migration->up();
    }

    public function setLaravelPermissions($app)
    {
        $app['config']->set('permission', [
            'models' => [
                'permission' => \Spatie\Permission\Models\Permission::class,
                'role' => \Spatie\Permission\Models\Role::class,
            ],
            'table_names' => [
                'roles' => 'roles',
                'permissions' => 'permissions',
                'model_has_permissions' => 'model_has_permissions',
                'model_has_roles' => 'model_has_roles',
                'role_has_permissions' => 'role_has_permissions',
            ],
            'column_names' => [
                'role_pivot_key' => null,
                'permission_pivot_key' => null,
                'model_morph_key' => 'model_id',
                'team_foreign_key' => 'team_id',
                'register_permission_check_method' => true,
                'display_permission_in_exception' => false,
                'enable_wildcard_permission' => false,
            ],
            'cache' => [
                'key' => 'spatie.permission.cache',
                'store' => 'default',
            ],
        ]);

        $app['config']->set('auth.providers.users.model', User::class);
    }

    protected function defineRoutes($router)
    {
        Route::group(['prefix' => config('richcms.admin_url'), 'as' => 'richcms::'], function () {
            //Auth
            Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [LoginController::class, 'login']);
            Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
            //Profile
            Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
            Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
            //Users
            Route::resource('users', UserController::class);
            Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
            Route::get('/users/{user}/activer', [UserController::class, 'activer'])->name('users.activer');
            Route::get('/users/{user}/desactiver', [UserController::class, 'desactiver'])->name('users.desactiver');
        });
    }
}
