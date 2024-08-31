<?php

namespace App\Http\Controllers\Modules\System\OrgStructure;

use App\Http\Controllers\Controller;
use App\Models\System\Department;
use App\Models\System\User;
use App\Models\UserAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;


class DepartmentController extends Controller
{
    protected $baseView = 'modules.systems.org_structures.departments';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $faculty = new Department();
        $limit = config('constants.pagination_records');
        $search = $request->has('q') ? $request->get('q') : null;
        $facultyId = $request->has('f') ? $request->get('f') : null;

        $query = Department::where(function ($query) use ($search, $facultyId) {
            if ($search != null) {
                $query->orWhere('name', 'like', '%' . $search . '%');
            }

            if ($facultyId != null) {
                $query->where('ptj_id', $facultyId);
            }
        });
        $departments = $query->orderBy('name', 'asc')->paginate($limit);

        // get total trashed
        $trash = Department::onlyTrashed()->count();
        session()->put('url.intended', url()->full());
        return $this->view([$this->baseView, 'index'], compact('departments', 'trash'))
                    ->with('i', ($request->input('page', 1) - 1) * $limit)
                    ->with('q', $search)->with('f', $facultyId);
    }

    /**
     * Fetch faculties record from HRIS using API.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetch()
    {
        $response = Http::withToken(env('UMAPI_WEBSITE_TOKEN'))->get(env('UMAPI_URL'). 'lookup/department');   

        if ($response->status() == 200) {
            $body = json_decode($response->body());
            $insert = [];

            ## get all ID from API
            $ids = [];
            foreach ($body->data as $data) {
                $ids[] = $data->JBT_KOD_JABATAN;
            }

            ## get all ID from existing table
            $currentIds = Department::get()->pluck('id')->toArray();

            ## not exists id from current existing table with data from API
            $deleteIds=array_diff($currentIds,$ids);

            DB::beginTransaction();
            try {
                foreach ($body->data as $key => $data) {
                    $department = Department::firstOrNew(['id' => $data->JBT_KOD_JABATAN]); // insert when found new record
                    $department->id = $data->JBT_KOD_JABATAN;
                    $department->ptj_id = $data->JBT_KOD_PTJ;
                    $department->short_name = $data->JBT_KTRGN_SINGKAT;
                    $department->name = $data->JBT_DESC_JABATAN;
                    $department->name_malay = $data->JBT_KTRGN_JABATAN;
                    $department->email = $data->JBT_EMAIL;
                    $department->is_academic = ($data->JBT_AKADEMIK == 'Y') ? true:false;
                    if (!$department)
                        $department->active = ($data->JBT_AKTIF == 'Y') ? true:false;
                    $department->save();
                }

                ## inactive the faculty that not exists in latest from API
                foreach ($deleteIds as $deleteId) {
                    $department = Department::find($deleteId);
                    $department->active = false;
                    $department->save();
                }
                DB::commit();
                return redirect()->route('departments.index')->with('toast_success', 'Departments fetched from HRIS successfully !');
            }
            catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('departments.index')->with('toast_error', $e->getMessage());
            }
        }
        else {
            $body = json_decode($response->body());
            return redirect()->route('departments.index')->with('toast_error', 'Error '. $response->status() . '. ' . $body->message);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAdmin(Request $request, Department $department)
    {
        $role = config('constants.role.adminDepartment');
        $modelType = config('constants.model_type.department');

        $roleId = Role::where('name', $role)->first();
        $input = $request->all();
        $user = User::find($input['admin-id']);
        $user->assignRole([config('constants.role.public')]);
        $user->assignRole($role);
        $insert = [
            'role_id' => $roleId->id, 
            'user_id' => $input['admin-id'], 
            'model_type' => $modelType,
            'model_id' => $department->id
        ];
        UserAssignment::create($insert);
        return redirect()->back()->with('toast_success', $user->name . ' successfully assign as department secretariat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSecretariat(Request $request, Department $department)
    {
        $role = config('constants.role.secretariat');
        $modelType = config('constants.model_type.department');

        $roleId = Role::where('name', $role)->first();
        $input = $request->all();
        $user = User::find($input['secretariat-id']);
        $user->assignRole($role);
        $insert = [
            'role_id' => $roleId->id, 
            'user_id' => $input['secretariat-id'], 
            'model_type' => $modelType,
            'model_id' => $department->id
        ];
        UserAssignment::create($insert);
        return redirect()->back()->with('toast_success', $user->name . ' successfully assign as department secretariat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
      
        $intendedUrl = session()->get('url.intended', url('/'));
        return $this->view([$this->baseView, 'show'], compact('department', 'intendedUrl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the active status the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateActive(Request $request)
    {
        if (!$request->ajax()) {
            abort(500);
        }

        $department = Department::find($request->id);
        $department->active = $request->active;
        $department->save();
        $status = ($request->active) ? ' activated!': ' inactive!';
        return response()->json([
            'status' => true, 
            'message' => $department->name . $status,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAssignment($id)
    {
        ## delete from user assignment
        $userAssignment = UserAssignment::find($id);
        $userAssignment->delete();

        ## get role information
        $role = Role::findById($userAssignment->role_id);

        ## revoke role admin faculty if this user dont have another faculty assignment
        $countUserAssignment = UserAssignment::where([
            'user_id' => $userAssignment->user_id, 
            'role_id' => $userAssignment->role_id, 
        ])->count();
        
        $user = User::find($userAssignment->user_id);
        if ($countUserAssignment == 0) {
            $user->removeRole($role->name);
        }

        return redirect()->back()->with('toast_success', $user->name . ' has been revoke as ' . $role->name);
    }
}
