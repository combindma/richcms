<?php

namespace Combindma\Richcms;

use Combindma\Backup\Backup;
use Combindma\Blog\Blog;
use Combindma\Gallery\Gallery;
use Combindma\Newsletter\Facades\Newsletter;
use Combindma\Redirector\Redirector;
use Combindma\Richcms\Http\Controllers\LoginController;
use Combindma\Richcms\Http\Controllers\ProfileController;
use Combindma\Richcms\Http\Controllers\RichcmsController;
use Combindma\Richcms\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RichcmsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('richcms')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_richcms_table');
    }

    public function packageRegistered()
    {
        Route::macro('richcms', function () {
            Route::group(['prefix' => config('richcms.admin_url'), 'as' => 'richcms::'], function () {
                //Auth
                Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
                Route::post('/login', [LoginController::class, 'login']);
                Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

                Route::group(['middleware' => ['auth', 'role:admin|editor|manager']], function () {
                    //Profile
                    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
                    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
                    //Settings
                    Route::put('/settings/update', [RichcmsController::class, 'updateSettings'])->name('settings.update');
                    //Clear cache
                    Route::get('/clear-cache', [RichcmsController::class, 'clearCache'])->name('clearCache');
                });

                Route::group(['middleware' => ['auth', 'role:admin']], function () {
                    //Users
                    Route::resource('users', UserController::class);
                    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
                    Route::get('/users/{user}/activer', [UserController::class, 'activer'])->name('users.activer');
                    Route::get('/users/{user}/desactiver', [UserController::class, 'desactiver'])->name('users.desactiver');
                    //Logs
                    Route::get('logs', [LogViewerController::class, 'index'])->name('logs');
                });
            });

            Route::group(['middleware' => ['auth', 'role:admin|editor|manager']], function () {
                Blog::routes(config('richcms.admin_url'));
                Newsletter::routes(config('richcms.admin_url'));
                Gallery::routes(config('richcms.admin_url'));
            });

            Route::group(['middleware' => ['auth', 'role:admin']], function () {
                Redirector::routes(config('richcms.admin_url'));
                Backup::routes(config('richcms.admin_url'));
            });
        });
    }
}
