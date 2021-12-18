<?php

namespace Combindma\Richcms\Database\Factories;

use Combindma\Richcms\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

Class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$12$nIfui.SLvpkFFZJcdPwz9ulPbgHu1EXIOGJFv6x4PJ/C8l0qVQnk6', //password
            'phone' => $this->faker->phoneNumber,
            'company' => $this->faker->company,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'country' => 'Maroc',
            'meta' => [],
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
