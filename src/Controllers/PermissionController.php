<?php

namespace Mkinyua53\Authorization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Permission;
use Session;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::with('roles','users')->orderBy('name')->get();

        return $permissions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            ]);

        $permission = new Permission;
        $permission->fill($request->all());
        $permission->save();

        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        $permission->load('users','roles');

        return $permission;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $permission->update($request->all());

        return $permission;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        
        return $permission;
    }

    /**
    *
    * Assign permission to user
    *
    * @param \App\Permission $permission
    * @param \App\User $user
    * @return Illuminate\Http\Response
    **/
    public function attachUser(Permission $permission, User $user)
    {
        $permission->users()->syncWithoutDetaching([$user->id]);

        return 'Permission granted to user';
    }

    /**
    *
    * Detach permission from user
    *
    * @param \App\Permission $permission
    * @param \App\User $user
    * @return Illuminate\Http\Response
    **/
    public function detachUser(Permission $permission, User $user)
    {
        $user->permissions()->detach($permission->id);

        return 'User detached of the permission';
    }

    /**
    *
    * Detach all permission from user
    *
    * @param int $user
    * @return Illuminate\Http\Response
    **/
    public function detachUserAll(User $user)
    {
        if ($user->id == \Auth::user()->id) {
            return response()->json('Not allowed',422);
        }
        $user->permissions()->detach();

        return 'User Stripped of all permissions';
    }
}
