<?php

use App\Models\User;
use Database\Seeders\LandingPageSeeder;

beforeEach(function () {
    $this->seed(LandingPageSeeder::class);
});

test('public landing page is accessible and loads CMS sections', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertInertia(fn ($page) => $page
            ->component('Welcome')
            ->has('sections')
            ->has('alumni')
            ->has('gallery')
            ->has('procedures')
        );
});

test('login page is accessible', function () {
    $response = $this->get('/login');

    $response->assertStatus(200)
        ->assertInertia(fn ($page) => $page->component('auth/Login'));
});

test('register page is accessible with schools and majors', function () {
    $response = $this->get('/register');

    $response->assertStatus(200)
        ->assertInertia(fn ($page) => $page
            ->component('auth/Register')
            ->has('schools')
            ->has('majors')
        );
});

test('admin can access landing cms editor and update sections', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'approved',
        'is_approved' => true,
    ]);

    $response = $this->actingAs($admin)->get('/admin/landing-cms');
    $response->assertStatus(200)
        ->assertInertia(fn ($page) => $page->component('Admin/LandingCms/Index'));

    $updateResponse = $this->actingAs($admin)->post('/admin/landing-cms/sections', [
        'sections' => [
            'hero_title' => 'Portal PKL Terbaik & Terstruktur 2026',
        ],
    ]);

    $updateResponse->assertRedirect();
    $this->assertDatabaseHas('landing_sections', [
        'key' => 'hero_title',
        'value' => 'Portal PKL Terbaik & Terstruktur 2026',
    ]);
});

test('admin can approve pending student accounts via SOLID AdminService', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'approved',
        'is_approved' => true,
    ]);

    $pendingStudent = User::factory()->create([
        'role' => 'siswa_pkl',
        'status' => 'pending',
        'is_approved' => false,
    ]);

    $response = $this->actingAs($admin)->post("/admin/approvals/{$pendingStudent->id}/approve");

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'id' => $pendingStudent->id,
        'status' => 'approved',
        'is_approved' => true,
    ]);
});
