<?php
namespace Modules\Site\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Site\Http\Traits\OrgStructureTrait;
use Modules\Site\Http\Traits\UserTrait;
use Exception;
use Modules\Site\Entities\UserContext;

use function App\Helpers\getUser;

class ManageAdminController extends Controller
{
    use OrgStructureTrait;
    use UserTrait;

    ## declare view path
    protected $baseView = 'site::org_structures.manage_admins';

    protected $roleId;
    protected $roleName;

    public function __construct() {
        $this->roleId = config('constants.role_id.admin');
        $this->roleName = config('constants.role.admin');
    }

    public function index(Request $request, $level, $id) {
        ## handling request and parameter
        $currentLevel   = $this->searchModelType('name', $level);
        $levelTitle     = ucwords($level);
        $model          = strval($currentLevel['model'])::find($id);

        ## set title page
        $title = "Manage - $levelTitle " . $model->name;

        ## get admin list
        $admins = UserContext::where([
            'model_type'    => $currentLevel['model'], 
            'model_id'      => $id,
            'role_id'       => $this->roleId,
        ])->get();

        ## view
        return $this->view([$this->baseView, 'index'], compact('currentLevel', 'levelTitle', 'admins'))
            ->with('model', $model)
            ->with('level', $level)
            ->with('id', $id)
            ->with('title', $title);
    }

    public function store(Request $request, $level, $id) {
        ## handle request
        $modelType   = $this->searchModelType('name', $level);
        $input = $request->all();
        DB::beginTransaction();
        try {
            ################################
            ## 1. MANAGE IF HAS NEW INPUT ##
            ################################
            if (isset($input['admin'])) {
                foreach ($input['admin'] as $email) {
                    $user = getUser($email);
    
                    ## assign user with role admin
                    $user->assignRole($this->roleName);
    
                    ## insert user context
                    UserContext::create([
                        'user_id'       => $user->id, 
                        'role_id'       => $this->roleId, 
                        'model_type'    => $modelType['model'], 
                        'model_id'      => $id,
                        'level'         => $modelType['level'], 
                    ]);
                }
            }

            ##########################
            ## 2. MANAGE DELETED ID ##
            ##########################
            if (isset($input['deleted'])) {
                foreach ($input['deleted'] as $deleteId) {
                    $userContext = UserContext::with('user')->find($deleteId);
                    $userContext->delete();
    
                    ## revoke role if not exists anymore
                    $user = $userContext->user;
                    $this->revokeRole($this->roleId, $this->roleName, $user);
                }
            }

            DB::commit();
            return redirect()->route('site.org-structure.manage-admin.index',['level' => $level, 'id' => $id])->with('toast_success', 'Data has been save successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return back()->with('toast_success', 'Failed to save data. Please try again.');
        }

    }
}
