<?php

namespace Mkinyua53\Authorization;

use Illuminate\Support\Facades\Route;

class Authorization {
    public static function routes()
    {
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
    }
}
