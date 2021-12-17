<?php

namespace Combindma\Richcms;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RichcmsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('richcms')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_richcms_table');
    }
}
