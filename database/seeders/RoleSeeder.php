<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'articles.viewAny', 'articles.create', 'articles.update', 'articles.delete', 'articles.publish',
            'categories.manage', 'tags.manage',
            'comments.moderate',
            'users.manage',
            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions($permissions);

        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->syncPermissions([
            'articles.viewAny', 'articles.create', 'articles.update', 'articles.delete', 'articles.publish',
            'categories.manage', 'tags.manage', 'comments.moderate',
        ]);

        $author = Role::firstOrCreate(['name' => 'author']);
        $author->syncPermissions([
            'articles.viewAny', 'articles.create', 'articles.update',
        ]);
    }
}
