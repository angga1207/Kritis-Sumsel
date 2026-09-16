<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_render_for_super_admin(): void
    {
        $this->seed(RoleSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('super_admin');

        Category::factory()->create();

        $routes = [
            'admin.dashboard',
            'admin.articles.index',
            'admin.articles.create',
            'admin.categories.index',
            'admin.tags.index',
            'admin.analytics.index',
            'admin.comments.index',
            'admin.users.index',
            'admin.settings.index',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($admin)->get(route($route));
            $response->assertOk();
        }
    }

    public function test_author_cannot_access_category_management(): void
    {
        $this->seed(RoleSeeder::class);

        $author = User::factory()->create();
        $author->assignRole('author');

        $this->actingAs($author)->get(route('admin.categories.index'))->assertForbidden();
    }
}
