<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Many to many relation between users and roles
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    /**
     * Many to many relation between roles and permissions
     *
     * @return object - permissions that belongs to current role
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    /**
     * Check if current role has specific permissions
     *
     * @param string|object|array $permission
     * @return bool
     */
    public function hasPermission($permission, $requireAll = false)
    {
        if (is_object($permission)) {
            $permission = $permission->name;
        }
        if (is_array($permission)) {
            if(!isset($permission['name'])) {
                return $this->hasPermissions($permission, $requireAll);
            }

            $permission = $permission['name'];
        }

        if ($this->permissions()->where('name', $permission)->first()) {
            return true;
        }
        return false;
    }

    /**
     * Check if current role has multiple permissions.
     *
     * @param mixed $permissions
     * @param bool $requireAll (optional) - if all permissions are required
     * @return bool
     */
    public function hasPermissions($permissions, $requireAll = false)
    {
        foreach ($permissions as $permission) {
            $hasPerm = $this->hasPermission($permission, $requireAll);

            if ($hasPerm && !$requireAll) {
                return true;
            } elseif (!$hasPerm && $requireAll) {
                return false;
            }
        }

        return $requireAll;
    }

    /**
     * Attach permission to current role.
     *
     * @param object|array $permission
     * @return void
     */
    public function attachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }
        if (is_array($permission)) {
            if(!isset($permission['id'])) {
                return $this->attachPermissions($permission);
            }

            $permission = $permission['id'];
        }
        $this->permissions()->attach($permission);
    }

    /**
     * Attach multiple permissions to current role.
     *
     * @param mixed $permissions
     * @return void
     */
    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }
    }

    /**
     * Detach permission from current role.
     *
     * @param object|array $permission
     * @return void
     */
    public function detachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }
        if (is_array($permission)) {
            if(!isset($permission['id'])) {
                return $this->detachPermissions($permission);
            }

            $permission = $permission['id'];
        }
        $this->permissions()->detach($permission);
    }

    /**
     * Detach multiple permissions from current role
     *
     * @param mixed $permissions
     * @return void
     */
    public function detachPermissions($permissions = null)
    {
        if (!$permissions) $permissions = $this->permissions()->get();
        foreach ($permissions as $permission) {
            $this->detachPermission($permission);
        }
    }
}
