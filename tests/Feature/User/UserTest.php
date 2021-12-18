<?php

namespace Combindma\Richcms\Tests\Feature\User;

use Combindma\Richcms\Enums\Country;
use Combindma\Richcms\Enums\Roles;
use Combindma\Richcms\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Faker\faker;
use function Pest\Laravel\from;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertTrue;
use Spatie\Permission\Models\Role;

/**
 * Set default data
 *
 * @return array
 */
function setData(array $data = [])
{
    return array_merge([
        'name' => strtolower(faker()->firstName),
        'email' => 'email@email.com',
        'password' => faker()->password,
        'phone' => '+212660286652',
        'company' => strtolower(faker()->words(2, true)),
        'address' => strtolower(faker()->address),
        'postcode' => strtolower(faker()->postcode),
        'city' => strtolower(faker()->city),
        'state' => strtolower(faker()->state),
        'country' => Country::MA,
        'meta' => [],
        'role' => Roles::Client,
    ], $data);
}

test('admin can create an user', function () {
    $data = setData();
    from(route('richcms::users.create'))
        ->post(route('richcms::users.store'), $data)
        ->assertRedirect(route('richcms::users.index'))
        ->assertSessionHasNoErrors();

    assertCount(1, $users = User::all());
    $user = $users->last();
    expect($user->name)->toBe($data['name']);
    expect($user->email)->toBe($data['email']);
    expect($user->phone)->toBe($data['phone']);
    expect($user->company)->toBe($data['company']);
    expect($user->address)->toBe($data['address']);
    expect($user->postcode)->toBe($data['postcode']);
    expect($user->city)->toBe($data['city']);
    expect($user->state)->toBe($data['state']);
    expect($user->country)->toBe($data['country']);
    assertTrue($user->hasRole($data['role']));
    assertTrue(Hash::check($data['password'], $user->password));
});

test('admin can update an user', function () {
    $user = User::factory()->create();
    $data = setData();
    from(route('richcms::users.edit', $user))
        ->put(route('richcms::users.update', $user), $data)
        ->assertRedirect(route('richcms::users.edit', $user))
        ->assertSessionHasNoErrors();
    $user->refresh();
    expect($user->name)->toBe($data['name']);
    expect($user->email)->toBe($data['email']);
    expect($user->phone)->toBe($data['phone']);
    expect($user->company)->toBe($data['company']);
    expect($user->address)->toBe($data['address']);
    expect($user->postcode)->toBe($data['postcode']);
    expect($user->city)->toBe($data['city']);
    expect($user->state)->toBe($data['state']);
    expect($user->country)->toBe($data['country']);
    assertTrue($user->hasRole($data['role']));
    assertTrue(Hash::check($data['password'], $user->password));
});

test('admin can delete user', function () {
    $user = User::factory()->create();
    from(route('richcms::users.index'))
        ->delete(route('richcms::users.destroy', $user))
        ->assertRedirect(route('richcms::users.index'));
    assertCount(0, User::all());
});

test('admin can restore user', function () {
    $user = User::factory()->create();
    $user->delete();
    assertCount(0, User::all());
    from(route('richcms::users.index'))
        ->post(route('richcms::users.restore', $user->id))
        ->assertRedirect(route('richcms::users.index'));
    assertCount(1, User::all());
});

test('admin can create user with valid data', function ($formInput, $formInputValue) {
    User::factory()->create(['email' => 'unique@email.com']);
    $data = setData([$formInput => $formInputValue,]);
    from(route('richcms::users.create'))
        ->post(route('richcms::users.store'), $data)
        ->assertRedirect(route('richcms::users.create'))
        ->assertSessionHasErrors($formInput);
    assertCount(0, User::all());
})->with([
    ['name' => ''],
    ['email' => ''],
    ['email' => 'invalid'],
    ['email' => 'unique@email.com'],
    ['password' => ''],
    ['country' => ''],
    ['role' => ''],
    ['role' => 'invalid'],
]);

test('admin can update user with valid data', function ($formInput, $formInputValue) {
    Role::create(['name' => Roles::Client]);
    User::factory()->create(['email' => 'unique@email.com']);
    $user = User::factory()->create(['email' => 'email@exemple.com']);
    $data = setData([$formInput => $formInputValue,]);
    from(route('richcms::users.edit', $user))
        ->put(route('richcms::users.update', $user), $data)
        ->assertRedirect(route('richcms::users.edit', $user))
        ->assertSessionHasErrors($formInput);
})->with([
    ['name' => ''],
    ['email' => ''],
    ['email' => 'invalid'],
    ['email' => 'unique@email.com'],
    ['country' => ''],
    ['role' => ''],
    ['role' => 'invalid'],
]);
