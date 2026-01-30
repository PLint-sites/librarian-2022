<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create(['is_onboarded' => 1]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
});

test('users can authenticate with remember me enabled', function () {
    $user = User::factory()->create(['is_onboarded' => 1]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'remember' => true,
    ]);

    $this->assertAuthenticated();
    
    // Verify that the remember cookie was set
    $response->assertCookie(Auth::guard()->getRecallerName());
});

test('users can authenticate with remember me disabled', function () {
    $user = User::factory()->create(['is_onboarded' => 1]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'remember' => false,
    ]);

    $this->assertAuthenticated();
    
    // Verify that the remember cookie was not set
    $response->assertCookieMissing(Auth::guard()->getRecallerName());
});

test('users cannot authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
