# Mkinyua53 Authorization

This package returns all the possible routes of `larapacks\authorization` package.
You need to have configured that package first in your laravel project.

## Installation
Use composer
  ```bash
  composer require mkinyua53/authorization
  ```
Insert the service provider in config\app.php providers array.

```php
  Mkinyua53\Authorization\AuthorizationServiceProvider::class,
```
## Usage

Add the relationships functions in

### \App\User
```php
public function roles()
{
    return $this->belongsToMany(Role::class);
}

public function permissions()
{
    return $this->belongsToMany(Permission::class);
}
```

### \App\Role
```php
public function users()
{
    return $this->belongsToMany(User::class);
}

public function permissions()
{
    return $this->belongsToMany(Permission::class);
}
```

### \App\Permission
```php
public function roles()
{
    return $this->belongsToMany(Role::class);
}

public function users()
{
    return $this->belongsToMany(User::class);
}
```

Insert the routes declaration in your `routes\web.php` or `routes\api.php`

```php
\Mkinyua53\Authorization\Authorization::routes();
```

The following routes will be added

```php
Route::group(['namespace' => '\Mkinyua53\Authorization'], function () {
    Route::resource('roles', 'RoleController', ['except' => ['create', 'edit']]);
    Route::resource('permissions', 'PermissionController', ['except' => ['create', 'edit']]);

    Route::post('roles/{role}/users/{user}/attach', 'RoleController@attachUser');
    Route::post('roles/{role}/permissions/{permission}/attach', 'RoleController@attachPermission');
    Route::post('roles/{role}/users/{user}/detach', 'RoleController@detachUser');
    Route::post('roles/{role}/permissions/{permission}/detach', 'RoleController@detachPermission');
    Route::post('roles/users/{user}/detach', 'RoleController@detachUserAll');
    Route::post('roles/permissions/{permission}/detach', 'RoleController@detachPermissionAll');

    Route::post('permissions/{permission}/users/{user}/attach', 'PermissionController@attachUser');
    Route::post('permissions/{permission}/users/{user}/detach', 'PermissionController@detachUser');
    Route::post('permissions/users/{user}/detach', 'PermissionController@detachUserAll');
});
```

### NOTE
1. This package is optimized to be used in an api, no views are provided

## Summary

| Route | Method |Parameters | Return | Extra |
| --- | --- | ---| --- | --- |
| roles | GET | null | `Collection` $roles | |
| roles | POST | `Request` $request | `App\Role` $role | |
| roles/{role} | GET | $roleId | `App\Role` $role | Returns `users` and `permissions` relationships as `Array` |
| roles/{role} | PUT / PATCH | `Request` $request, $roleId | `App\Role` $role ||
| roles/{role} | DELETE | $roleId | `App\Role` $role | |
| ~ | ~ | ~ | ~ | ~ |
| permissions | GET | null | `Collection` $permissions | |
| permissions | POST | `Request` $request | `App\Permission` $permission | |
| permissions/{permission} | GET | $permissionId | `App\Permission` $permission | Returns `users` and `roles` relationships as `Array` |
| permissions/{permission} | PUT / PATCH | `Request` $request, $permissionId | `App\Permission` $permission ||
| permissions/{permission} | DELETE | $permissionId | `App\Permission` $permission | |
| ~ | ~ | ~ | ~ | ~ |
| roles/{role}/users/{user}/attach | POST | $roleId, $userId | `string` 'User granted the role' | Grant the role to the user |
| roles/{role}/permissions/{permission}/attach | POST | $roleId, $permissionId | `string` 'Permission granted the role' | Grants the role to the permission |
| roles/{role}/users/{user}/detach | POST | $roleId, $userId | `string` 'User detached of role' | Detaches the role from the user |
| roles/{role}/permissions/{permission}/detach | POST | $roleId, $permissionId | `string` 'Permission detached from role' | Detaches the role from the permission |
| roles/users/{user}/detach | POST | $userId | `string` 'User detached all role' | Detaches all roles from a user |
| roles/permissions/{permission}/detach | POST | $permissionId | `string` 'Permission detached of all role' | Detaches all roles from permission |
| ~ | ~ | ~ | ~ | ~ |
| permissions/{permission}/users/{user}/attach | POST | $permissionId, $userId | `string` 'Permission granted to user' | Grants the permission to the user |
| permissions/{permission}/users/{user}/detach | POST | $permissionId, $userId | `string` 'User detached of the permission' | Detach permission from user |
| permissions/users/{user}/detach | POST | $userId | `string` 'User detached of all permission' | Detach all permission from user |
