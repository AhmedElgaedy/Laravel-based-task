<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'View Users',
                'slug' => 'view-users',
                'description' => 'Can view users',
            ],
            [
                'name' => 'Create Users',
                'slug' => 'create-users',
                'description' => 'Can create users',
            ],
            [
                'name' => 'Edit Users',
                'slug' => 'edit-users',
                'description' => 'Can edit users',
            ],
            [
                'name' => 'Delete Users',
                'slug' => 'delete-users',
                'description' => 'Can delete users',
            ],



            [
                'name' => 'View Posts',
                'slug' => 'view-posts',
                'description' => 'Can view posts',
            ],
            [
                'name' => 'Create Posts',
                'slug' => 'create-posts',
                'description' => 'Can create posts',
            ],
            [
                'name' => 'Edit Posts',
                'slug' => 'edit-posts',
                'description' => 'Can edit posts',
            ],
            [
                'name' => 'Delete Posts',
                'slug' => 'delete-posts',
                'description' => 'Can delete posts',
            ],
            [
                'name' => 'Publish Posts',
                'slug' => 'publish-posts',
                'description' => 'Can publish posts',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $this->assignPermissionsToRoles();
    }

    private function assignPermissionsToRoles(): void
    {
        $admin = Role::where('slug', 'admin')->first();
        $editor = Role::where('slug', 'editor')->first();
        $user = Role::where('slug', 'user')->first();
        $moderator = Role::where('slug', 'moderator')->first();
        $author = Role::where('slug', 'author')->first();

        $admin->permissions()->attach(Permission::all());

        $editor->permissions()->attach(
            Permission::whereIn('slug', [
                'view-posts',
                'create-posts',
                'edit-posts',
                'delete-posts',
                'publish-posts'
            ])->get()
        );


        $user->permissions()->attach(
            Permission::whereIn('slug', [
                'view-posts',
                'create-posts',
                'edit-posts',
                'delete-posts',
            ])->get()
        );

    }
}