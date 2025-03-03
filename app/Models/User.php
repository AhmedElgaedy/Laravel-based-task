<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasRoles;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }

    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            Role::class,
            'role_user',
            'permission_role'
        );
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }
        return $role->intersect($this->roles)->isNotEmpty();
    }

    public function hasAnyRole($roles)
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }
        return $this->roles->whereIn('slug', $roles)->isNotEmpty();
    }

    public function hasAllRoles($roles)
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }
        return collect($roles)->every(function ($role) {
            return $this->hasRole($role);
        });
    }

    public function hasPermission($permission)
    {
        return $this->permissions->contains('slug', $permission);
    }

    public function scopeByRole(Builder $query, string|array $roles): Builder
    {
        return $query->whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('slug', (array) $roles);
        });
    }

    /**
     * Scope active users
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeWithMinPosts(Builder $query, int $count): Builder
    {
        return $query->has('posts', '>=', $count);
    }
}
