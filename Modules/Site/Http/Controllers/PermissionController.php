<?php

namespace Modules\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Modules\Site\Entities\Permission;
use Modules\Site\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    protected $baseView = 'site::permissions';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 20;
        $search = $request->has('q') ? $request->get('q') : null;

        $permissions = Permission::isParent()->with('children')->where(function ($query) use ($search) {
            if ($search != null) {
                $query->where('name', 'like', '%' . $search . '%');
            }

        })->orderBy('id', 'asc')->paginate($limit);
        session()->put('backUrl', config('app.https') ? str_replace('http', 'https', URL::full()) : URL::full());
        return $this->view([$this->baseView, 'index'], compact('permissions'))
                    ->with('title', __('Permission'))
                    ->with('i', ($request->input('page', 1) - 1) * $limit)->with('q', $search);
    }

    public function create(Request $request) {
        $permission = $request->has('id') ? Permission::find($request->get('id')) : null;
        return $this->view([$this->baseView, 'create'], compact('permission'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $permission = $request->has('id') ? Permission::find($request->get('id')) : null;

        $data = $request->validated();

        if ($permission != null) {
            $data['parent_id'] = $permission->id;
        }

        $newPermission = Permission::create($data);

        if ($permission != null) {
            return redirect()->route('site.permissions.show', $permission->id)->with('toast_success', 'Permission successfully created!');
        }


        return redirect()->route('site.permissions.show', $newPermission)->with('toast_success', 'Permission successfully created!');
    }

    /**
     * Display the specified resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Site\Entities\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Permission $permission) {
        $search = $request->has('q') ? $request->get('q') : null;

        // get permission children
        $permissions = Permission::where('parent_id', $permission->id)
                                ->when(($search != null), function ($query) use ($search) {
                                    $query->where('name', 'like', '%' . $search . '%');
                                })
                                ->orderBy('id', 'asc')
                                ->get();

        return $this->view([$this->baseView, 'show'], compact('permission', 'permissions'))
                    ->with("q", $search)
                    ->with('title', __('Manage :name', ['name' => $permission->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roleHasPermission = DB::table('sys_role_has_permissions')->where('permission_id', $id)->count();

        // this permission is already assigned to a role
        if ($roleHasPermission > 0) {
            $message = 'Permission unsuccessfully deleted';
            return redirect()->back()->with('toast_error', $message);
        }
        else {
            Permission::find($id)->delete(); // delete parent
            Permission::where('parent_id', $id)->delete(); // delete children
            $message = 'Permission successfully deleted';
            return redirect()->back()->with('toast_success', $message);
        }

        
    }
}
