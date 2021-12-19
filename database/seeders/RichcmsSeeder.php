<?php

namespace Combindma\Richcms\Database\Seeders;

use Combindma\Richcms\Enums\Roles;
use Combindma\Richcms\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RichcmsSeeder extends Seeder
{
    public function run()
    {
        foreach (Roles::getValues() as $role) {
            Role::create(['name' => $role]);
        }

        $user = User::create([
            'name' => 'administrator',
            'email' => 'a@a.a',
            'password' => 'pass',
            'company' => 'Combind',
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'active' => 1,
        ]);

        $user->assignRole(Roles::Admin);
    }
}
