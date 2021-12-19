<?php

use Combindma\Richcms\Enums\Roles;
use Combindma\Richcms\Tests\TestCase;
use Spatie\Permission\Models\Role;

uses(TestCase::class)
    ->beforeEach(function () {
        foreach (Roles::getValues() as $role) {
            Role::create(['name' => $role]);
        }
    })
    ->in(__DIR__);
