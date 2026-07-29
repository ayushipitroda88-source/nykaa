<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function userCount(): int
    {
        return $this->admins()->count();
    }

    public function hasPermission(string $permissionSlug): bool
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }

    public function hasAnyPermission(array $permissionSlugs): bool
    {
        return $this->permissions()->whereIn('slug', $permissionSlugs)->exists();
    }

    public function hasAllPermissions(array $permissionSlugs): bool
    {
        $count = $this->permissions()->whereIn('slug', $permissionSlugs)->count();
        return $count === count($permissionSlugs);
    }

    public function getModulePermissions(string $module): array
    {
        return $this->permissions()
            ->where('module', $module)
            ->pluck('action')
            ->toArray();
    }

    public function isSuperAdmin(): bool
    {
        return $this->slug === 'super-admin';
    }
}