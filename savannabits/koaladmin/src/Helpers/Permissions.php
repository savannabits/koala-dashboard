<?php


namespace Savannabits\Koaladmin\Helpers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions
{
    static function seedPermissions(array $perms, array $roleNames = ["administrator"],$guard=null) {
        if (!$guard) {
            $guard = config('auth.defaults.guard');
        }
        $perms = collect($perms);
        $permissions = $perms->map(function ($permission) use($guard) {
            return [
                'name' => $permission,
                'guard_name' => $guard,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        })->toArray();

        $roles = collect($roleNames)->map(function($role) use ($perms, $guard) {
            return [
                'name' => $role,
                'title' => str_replace("-"," ", Str::title($role)),
                'enabled' => true,
                'guard_name' => $guard,
                'permissions' => $perms,
            ];
        });

        $tableNames = config('permission.table_names', [
            'roles' => 'roles',
            'permissions' => 'permissions',
            'model_has_permissions' => 'model_has_permissions',
            'model_has_roles' => 'model_has_roles',
            'role_has_permissions' => 'role_has_permissions',
        ]);

        DB::transaction(function () use($tableNames, $permissions, $roles) {
            foreach ($permissions as $permission) {
                $permissionItem = DB::table($tableNames['permissions'])->where([
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name']
                ])->first();
                if ($permissionItem === null) {
                    DB::table($tableNames['permissions'])->insert($permission);
                }
            }

            foreach ($roles as $role) {
                $permissions = $role['permissions'];
                unset($role['permissions']);

                $roleItem = DB::table($tableNames['roles'])->where([
                    'slug' => $role['slug'],
                    'guard_name' => $role['guard_name']
                ])->first();
                if ($roleItem !== null) {
                    $roleId = $roleItem->id;

                    $permissionItems = DB::table($tableNames['permissions'])->whereIn('name', $permissions)->where(
                        'guard_name',
                        $role['guard_name']
                    )->get();
                    foreach ($permissionItems as $permissionItem) {
                        $roleHasPermissionData = [
                            'permission_id' => $permissionItem->id,
                            'role_id' => $roleId
                        ];
                        $roleHasPermissionItem = DB::table($tableNames['role_has_permissions'])->where($roleHasPermissionData)->first();
                        if ($roleHasPermissionItem === null) {
                            DB::table($tableNames['role_has_permissions'])->insert($roleHasPermissionData);
                        }
                    }
                }
            }
        });
        app()['cache']->forget(config('permission.cache.key'));
    }
    public static function getGroupedPermissions() {
        $perms = Permission::all()
            ->map(function($perm) {
                /**@var Permission $perm*/
                $exploded_name = explode(".",$perm->name);
                $group = str_replace("-", " ",Str::title(collect($exploded_name)->first()));
                $verb = (collect($exploded_name)->count() > 1) ? collect($exploded_name)->last() : "";
                $perm->group = $group;
                $perm->title = Str::title($verb?"$verb $group": "$group");
                return $perm;
            })->groupBy("group");
        return $perms;
    }

    /**
     * @param Role|App\Models\Role|mixed $role
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|Permission[]
     */
    public static function getRolePermissionMatrix($role) {
        $perms = Permission::all()
            ->map(function($perm) use ($role) {
                /**@var Permission $perm*/
                $exploded_name = explode(".",$perm->name);
                $group_name = str_replace("-", " ",Str::title(collect($exploded_name)->first()));
                $verb = (collect($exploded_name)->count() > 1) ? collect($exploded_name)->last() : "";
                $assigned = $role->hasPermissionTo($perm);
                $perm->group_name = $group_name;
                $perm->group_slug = Str::slug($group_name);
                $perm->title = Str::title($verb?"$verb $group_name": "$group_name");
                $perm->assigned = $assigned;
                return $perm;
            })->groupBy("group_name")->map(function($group) {
                $first = $group[0];
                $permGroup = [
                    "name" => $first->group_name,
                    "slug" => $first->group_slug,
                    "perms" => $group->values()
                ];
                return $permGroup;
            })->keyBy('slug');
        return $perms;
    }
}
