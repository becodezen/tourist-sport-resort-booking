<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->slugify($value);
    }

    protected function slugify($name)
    {
        $slug = str_replace(' ', '-', strtolower($name));

        $slug = str_replace('.', '', $slug);

        $user = User::where('slug', $slug)->get();

        if (count($user) > 0) {
            $slug = $slug.'-'.$user->count();
        }

        return $slug;
    }

    public function resorts()
    {
        return $this->belongsToMany(Resort::class, 'resort_user', 'user_id', 'resort_id');
    }

    public function resort()
    {
        //return $this->resorts()->first();
        return Resort::find(DB::table('resort_user')->where('user_id', $this->id)->first()->resort_id);
    }

    /**
     * Attach Resort to the User
     *
     * @var array
     */
    public function attachResort($resort)
    {
        if (is_object($resort)) {
            $resort = $resort->getKey();
        }else if (is_array($resort)) {
            $resort = $resort['id'];
        }

        $this->resorts()->attach($resort);
    }

    /**
     * Detach Resort to the User
     *
     * @var array
     */
    public function detachResort($resort)
    {
        if (is_object($resort)) {
            $resort = $resort->getKey();
        }else if (is_array($resort)) {
            $resort = $resort['id'];
        }

        $this->resorts()->detach($resort);
    }

    /**
     * Many to many relation between users and roles
     *
     * @return object|array - roles that belongs to current user
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Get single role to verify permission, as it has a many to many relationship
     *
     * @return object|array - roles that belongs to current user
     */
    public function role()
    {
        return $this->roles()->first();
        // return \App\Models\Role::find(DB::table('role_user')->where('user_id', $this->id)->first()->role_id);
    }

    /**
     * Checks if user has a specific permission or a group of permissions
     *
     * @param mixed $permission - Permission name, or a list of permission
     * @param bool $requireAll - if required all from the list
     * @return bool
     */
    public function canDo($permission, $requireAll = false)
    {
        return $this->role()->hasPermission($permission, $requireAll);
    }

    /**
     * Checks if user belongs to a specific user role
     *
     * @param mixed $role
     * @return bool
     */
    public function isA($role)
    {
        return $this->hasRole($role);
    }

    /**
     * Authorize User Role
     *
     * @param string|object|array $role
     * @return bool or abort
     */
    public function authorizeRole($roles)
    {
        if ($this->hasRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }

    /**
     * Authorize User Permission
     *
     * @param mixed $permission - Permission name, or a list of permission
     * @param bool $requireAll - if required all from the list
     * @return bool or abort
     */
    public function authorizePermissions($perms, $requireAll = false)
    {
        if ($this->role()->hasPermission($perms, $requireAll)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }

    /**
     * Check if current user has specific roles
     *
     * @param string|object|array $role
     * @return bool
     */
    public function hasRole($role, $requireAll = false)
    {
        if (is_object($role)) {
            $role = $role->name;
        }
        if (is_array($role)) {
            if(!isset($role['name'])) {
                return $this->hasRoles($role, $requireAll);
            }

            $role = $role['name'];
        }

        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    /**
     * Check if current user has multiple roles.
     *
     * @param mixed $roles
     * @param bool $requireAll (optional) - if all roles are required
     * @return bool
     */
    public function hasRoles($roles, $requireAll = false)
    {
        foreach ($roles as $role) {
            $hasRol = $this->hasRole($role);

            if ($hasRol && !$requireAll) {
                return true;
            } elseif (!$hasRol && $requireAll) {
                return false;
            }
        }

        return $requireAll;
    }

    /**
     * Attach role to current user.
     *
     * @param object|array $role
     * @return void
     */
    public function attachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }
        if (is_array($role)) {
            if(!isset($role['id'])) {
                return $this->attachRoles($role);
            }

            $role = $role['id'];
        }
        $this->roles()->attach($role);
    }


    /**
     * Attach multiple roles to current user.
     *
     * @param mixed $roles
     * @return void
     */
    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            $this->attachRole($role);
        }
    }

    /**
     * Detach role from current user.
     *
     * @param object|array $role
     * @return void
     */
    public function detachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }
        if (is_array($role)) {
            if(!isset($role['id'])) {
                return $this->detachRoles($role);
            }

            $role = $role['id'];
        }
        $this->roles()->detach($role);
    }

    /**
     * Detach multiple roles from a user
     *
     * @param mixed $roles
     */
    public function detachRoles($roles=null)
    {
        if (!$roles) $roles = $this->roles()->get();
        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }

}
