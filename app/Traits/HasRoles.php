<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            Role::class,
            'role_user',
            'permission_role',
            'id',
            'id'
        );
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }
        $this->roles()->syncWithoutDetaching($role);
    }

    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }
        return $role->intersect($this->roles)->isNotEmpty();
    }

    public function hasAnyRole($roles): bool
    {
        if (is_string($roles)) {
            return $this->roles->contains('slug', $roles);
        }
        return $this->roles->whereIn('slug', $roles)->isNotEmpty();
    }

    public function hasAllRoles($roles): bool
    {
        if (is_string($roles)) {
            return $this->roles->contains('slug', $roles);
        }
        return collect($roles)->every(fn($role) => $this->hasRole($role));
    }

    public function hasPermission($permission): bool
    {
        return $this->permissions->contains('slug', $permission);
    }
}