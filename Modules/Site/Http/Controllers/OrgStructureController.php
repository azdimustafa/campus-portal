<?php

namespace Modules\Site\Http\Controllers;

use Modules\Site\Entities\Ptj;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Modules\Site\Entities\UserContext;
use Modules\Site\Http\Traits\OrgStructureTrait;

class OrgStructureController extends Controller
{
    use OrgStructureTrait;
    protected $baseView = 'site::org_structures';

    /**
     * Display a treeview of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = $request->has('q') ? $request->get('q') : null;
        $user = auth()->user();
        $role = Role::findByName(config('constants.role.superadmin'));
        $treeviewIds = $this->treeview($role);

        $treeviewOpen = 'block';
        if (count($treeviewIds['facultyIds']) > 1) {
            $treeviewOpen = 'none';
        }

        $query = Ptj::with([
            'departments', 
            'departments.divisions', 
            'departments.divisions.sections', 
            'departments.divisions.sections.units',
        ]);
        $query = $query->where(function ($query) use ($search) {
            if ($search != null) {
                $query->orWhere('name', 'like', '%' . $search . '%');
            }
        });
        $faculties = $query->active()->oldest('name')->get();

        ## get authorize id to manage
        // $allowIds = [];
        $allowIds = $this->authorizeStructure($role);

        session()->put('url.intended', URL::full());
        return $this->view([$this->baseView, 'index'], compact('faculties', 'treeviewIds', 'allowIds', 'treeviewOpen'))->with('q', $search);
    }

    /**
     * Display form to create a new sub level
     *
     * @return \Illuminate\Http\Response
     */
    public function createSub($level, $id) {

        $currentLevel = $this->searchModelType('name', $level);
        $nextLevel = $this->getNextLevel($level);

        ## get model
        $model = strval($currentLevel['model'])::find($id);

        ## not allowed the last level to create new sub
        if ($nextLevel == false) {
            return back()->with('toast_error', 'Last level');
        }

        ## create page title
        $title = 'Create new ' . $nextLevel['name'];
        $levelTitle = ucwords($nextLevel['name']);
        $intendedUrl = session()->get('url.intended', url('/'));
        return $this->view([$this->baseView, 'create_sub'], compact('level', 'id', 'title', 'levelTitle', 'nextLevel', 'currentLevel', 'intendedUrl', 'model'));
    }

    /**
     * Display form to create a new sub level
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSub(Request $request, $level, $id) {
        $request->validate([
            'code' => 'max:50',
            'short_name' => 'max:100', 
            'name' => 'max:255|required', 
            'name_my' => 'max:255|required', 
        ]);
        $level = $this->searchModelType('name', $level);
        $updateData = $request->all();
        $updateData['active'] = $request->active == 'on' ? true:false;
        $model = strval($level['model'])::find($id);

        $model->update($updateData);
        return back()->with('toast_success', ucwords($level['name']) . ' has been update successfully');
    }

    /**
     * Store the data to a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function storeSub(Request $request, $level, $id) {

        $request->validate([
            'code' => 'max:50',
            'short_name' => 'max:100', 
            'name' => 'max:255|required', 
            'name_my' => 'max:255|required', 
        ]);

        $level = $this->searchModelType('name', $level);
        
        $insertData['ptj_id'] = $request->ptj_id;
        $insertData['department_id'] = $request->department_id;

        ## current level section or unit
        if ($level['level'] >= 4) {
            $insertData['division_id'] = $request->division_id;
        }

        ## current level is unit
        if ($level['level'] >= 5) {
            $insertData['section_id'] = $request->section_id;
        }
        
        $insertData = $request->all();
        $insertData['active'] = $request->active == 'on' ? true:false;
        
        $model = strval($level['model'])::create($insertData);
        return redirect()->route('site.org-structure.index')->with('toast_success', 'Data has been save successfully');
    }

    /**
     * Destroy sub from a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function destroySub(Request $request, $level, $id) {
        $level = $this->searchModelType('name', $level);
        $model = strval($level['model'])::find($id);
        $model->delete();

        // delete with user context sekali
        UserContext::where([
            'model_type' => $level['model'], 
            'model_id' => $id, 
            'role_id' => config('constants.role_id.admin'),
        ])->delete();

        return back()->with('toast_success', ucwords($level['name']) . ' delete successfully');
    }
}
