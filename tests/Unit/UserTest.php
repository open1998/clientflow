<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

uses(Tests\TestCase::class);

test('user has expected fillable attributes', function () {
    $user = new User();

    expect($user->getFillable())->toEqual(['name', 'email', 'password']);
});

test('user has expected hidden attributes', function () {
    $user = new User();

    expect($user->getHidden())->toEqual(['password', 'remember_token']);
});

test('user has expected casts', function () {
    $user = new User();

    expect($user->getCasts())->toMatchArray([
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ]);
});

test('password is automatically hashed when set', function () {
    $user = User::factory()->create([
        'password' => 'secret-password',
    ]);

    expect(Hash::check('secret-password', $user->password))->toBeTrue();
});

test('user can be created via factory', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->not->toBeEmpty();
    expect($user->email)->not->toBeEmpty();
});
