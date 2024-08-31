<?php

namespace Modules\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\ModuleRequest;
use Modules\Site\Entities\Module;
use Modules\Site\Entities\ModuleOwner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Modules\Site\Entities\UserType;

use function App\Helpers\getUser;

class ModuleController extends Controller
{
    protected $baseView = 'site::modules';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $limit = config('constants.pagination_records');
        $search = $request->has('q') ? $request->get('q') : null;

        ## get list data
        $modules = Module::with('owners', 'owners.user')->where(function ($query) use ($search) {
            if ($search != null) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('code', 'like', '%' . $search . '%');
            }
        })->latest('created_at')->paginate($limit);
        $modules->setPath('');
        
        ## store current url 
        session()->put('backUrl', config('app.https') ? str_replace('http', 'https', URL::full()) : URL::full());

        return $this->view([$this->baseView, 'index'], compact('modules'))
                    ->with('i', ($request->input('page', 1) - 1) * $limit)
                    ->with('q', $search)
                    ->with('title', __('site::module.title'));
    } ## end function index

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userTypes = UserType::all()->pluck('name', 'id')->toArray();
        return $this->view([$this->baseView, 'create'], compact(('userTypes')))->with('title', __('site::module.add_new_module'));
    } ## end function create

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ## form validation
        $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:10', 
            'description' => 'max:255'
        ]);

        DB::beginTransaction();

        try {
            ## store input
            $module = Module::create($request->all());
            
            ## store owners
            $users = $request->users;
            if (count($users) > 0) {
                ## loop each user email address to create/new user and assign role ModuleOwner
                foreach ($users as $user) {
                    $user = getUser($user);
                    ModuleOwner::create(['module_id' => $module->id, 'user_id' => $user->id]);
                    $user->assignRole(config('constants.role.moduleAdmin'));
                }
            }
            DB::commit();
            return redirect()->route('site.modules.index')->with('toast_success', __('message.store_success'));
        }
        catch(Exception $e) {
            DB::rollBack();
            return back()->with('toast_warning', __('message.store_failed') . ' -> ' . $e->getMessage())->withInput($request->all);
        }
    } ## end function store

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {   
        $userTypes = UserType::all()->pluck('name', 'id')->toArray();
        return $this->view([$this->baseView, 'edit'], compact('module', 'userTypes'))
                    ->with('title', __('page.title_edit_module', ['title' => $module->name]));
    } ## end function edit

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        ## form validation
        $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:10', 
            'description' => 'max:255'
        ]);

        $input = $request->all();
        DB::beginTransaction();
        try {
            $module->update($input);

            ##########################
            ## store owners
            ##########################
            $users = $request->users ?? [];
            if (count($users) > 0) {
                ## loop each user email address to create/new user and assign role ModuleOwner
                foreach ($users as $user) {
                    $user = getUser($user);
                    ModuleOwner::create(['module_id' => $module->id, 'user_id' => $user->id]);
                    $user->assignRole(config('constants.role.moduleOwner'));
                }
            }

            ##########################
            ## 2. MANAGE DELETED ID ##
            ##########################
            if (isset($input['deleted'])) {
                foreach ($input['deleted'] as $deleteId) {
                    $moduleOwner = ModuleOwner::with('user')->find($deleteId);
                    $user = $moduleOwner->user;
                    $moduleOwner->delete();
                    
                    ## Do not remove role if the current user has another module
                    $userHasModules = ModuleOwner::where('user_id', $user->id)->count('id');
                    if ($userHasModules <= 0) 
                        $user->removeRole(config('constants.role.moduleOwner'));
                }
            }

            DB::commit();
            return redirect()->to(session()->has('backUrl') ? session()->get('backUrl') : route('home'))->with('toast_success', __('message.update_success'));
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('toast_warning', __('message.update_failed') . ' -> ' . $e->getMessage())->withInput($request->all);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Module  $module
     * @return \Illuminate\Http\Response
     */
    public function updateOwner(Request $request, Module $module)
    {
        $input = $request->all();
        DB::beginTransaction();

        try {
            ##########################
            ## store owners
            ##########################
            $users = $request->users ?? [];
            if (count($users) > 0) {
                ## loop each user email address to create/new user and assign role ModuleOwner
                foreach ($users as $user) {
                    $user = getUser($user);
                    ModuleOwner::create(['module_id' => $module->id, 'user_id' => $user->id]);
                    $user->assignRole(config('constants.role.moduleOwner'));
                }
            }

            ##########################
            ## 2. MANAGE DELETED ID ##
            ##########################
            if (isset($input['deleted'])) {
                foreach ($input['deleted'] as $deleteId) {
                    $moduleOwner = ModuleOwner::with('user')->find($deleteId);
                    $user = $moduleOwner->user;
                    $moduleOwner->delete();
                    
                    ## Do not remove role if the current user has another module
                    $userHasModules = ModuleOwner::where('user_id', $user->id)->count('id');
                    if ($userHasModules <= 0) 
                        $user->removeRole(config('constants.role.moduleOwner'));
                }
            }

            DB::commit();
            return back()->with('toast_success', __('message.update_success'));
        }
        catch (Exception $e) {
            DB::rollBack();
            return back()->with('toast_warning', __('message.update_failed') . ' -> ' . $e->getMessage())->withInput($request->all);
        }
    }

    public function updateActive(Request $request, Module $module) {
        if (!$request->ajax()) {
            abort(500);
        }

        $module = Module::findOrFail($request->id);
        $module->update([
            'active' => $request->active,
        ]);
        $status = ($request->active) ? ' activated!': ' inactive!';
        return response()->json([
            'status' => true, 
            'message' => __('site::module.title') . ' ' . $module->name . $status,
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
        DB::beginTransaction();

        try {
            $menu = Module::with(['owners', 'owners.user'])->find($id);
            $owners = $menu->owners;
            $menu->delete();

            foreach ($owners as $owner) {
                $owner->delete();
                $user = $owner->user;

                ## Do not remove role if the current user has another module
                $userHasModules = ModuleOwner::where('user_id', $user->id)->whereNotIn('module_id', [$id])->count('id');
                if ($userHasModules <= 0) 
                    $user->removeRole(config('constants.role.moduleOwner'));
            }
            DB::commit();
            return back()->with("toast_success", __('message.delete_success'));
        }
        catch (Exception $e) {
            DB::rollBack();
            return back()->with("error", __('message.delete_failed'));
        }
    }
}
