<?php

use Combindma\Richcms\Http\Controllers\ProfileController;
use Combindma\Richcms\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\from;
use function PHPUnit\Framework\assertTrue;

test('admin can update his profile', function () {
    $user = User::factory()->create();
    actingAs($user);
    $data = [
        'name' => 'new-name',
        'email' => 'new@email.com',
        'password' => 'new-password',
    ];

    from(action([ProfileController::class, 'index']))->put(action([ProfileController::class, 'update']), $data)->assertRedirect(action([ProfileController::class, 'index']));
    $user->refresh();
    expect($user->name)->toBe($data['name']);
    expect($user->email)->toBe($data['email']);
    assertTrue(Hash::check($data['password'], $user->password));
});
