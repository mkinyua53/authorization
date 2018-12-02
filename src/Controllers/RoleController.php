<?php

namespace Mkinyua53\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
	/**
	 * Display a listing of roles
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return Role::all()->load('permissions', 'users');
	}

	/**
	 * Create a new role
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
			$this->validate($request, [
				'name'    => 'required|unique:roles,name',
			]);

			$role = Role::create($request->all());

			return $role;
	}

	/**
	 * Display the specified role
	 *
	 * @param \App\Role $role
	 * @return \Illuminate\Http\Response
	 */
	public function show()
	{
			return $role->load('permissions', 'users');
	}

	/**
	 * Update the specified role in storage
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Role $role
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Role $role)
	{
			$this->validate($request, [
				'name'  => 'required|unique,roles,name,'.$role->id,
			]);

			$role->update($request->all());

			return $role->load('permissions', 'users');
	}

	/**
	 * Delete the specified role
	 *
	 * @param \App\Role $role
	 * @return \Illuinate\Http\Response
	 */
	public function destroy(Role $role)
	{
			$role->delete();

			return $role;
	}

	/**
		*
		* Attach role to user
		*
		* @param \App\Role $role
		* @param \App\User $user
		* @return \Illuminata\Http\Response
		*/
		public function attachUser(Role $role, User $user)
		{
				$role->users()->syncWithoutDetaching([$user->id]);

				return 'User granted the role';
		}

		/**
		*
		* Attach a permission to user
		*
		* @param \App\Role $role
		* @param \App\Permission $permission
		* @return Illuminate\Http\Response
		*/
		public function attachPermission(Role $role, Permission $permission)
		{
				$permission->roles()->syncWithoutDetaching([$role->id]);

				return 'Permission granted the role';
		}

		/**
		*
		* Detach a user from a role
		*
		* @param \App\Role $role
		* @param \App\User $user
		* @return Illuminate\Http\Response
		**/
		public function detachUser(Role $role, User $user)
		{
				$user->roles()->detach($role->id);

				return 'User Detached of Role';
		}

		/**
		*
		* Detach a permission from a role
		*
		* @param \App\Role $role
		* @param \App\Permission $permission
		* @return Illuminate\Http\Response
		**/
		public function detachPermission(Role $role, Permission $permission)
		{
				$permission->roles()->detach($role->id);

				return 'Permission Detached from Role';
		}

		/**
		*
		* Detach all roles from a user
		*
		* @param \App\User $user
		* @return Illuminate\Http\Response
		**/
		public function detachUserAll(User $user)
		{
				if ($user->id == \Auth::user()->id) {
						return response()->json('Not allowed', 422);
				}
				$user->roles()->detach();

				return 'User Detached all Roles';
		}

		/**
		*
		* Detach all roles from a permission
		*
		* @param \App\Permission $permission
		* @return Illuminate\Http\Response
		**/
		public function detachPermissionAll(Permission $permission)
		{
				$permission->roles()->detach();

				return 'Permission Detached of all roles';
		}
}
