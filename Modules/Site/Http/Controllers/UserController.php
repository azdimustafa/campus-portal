<?php
namespace Modules\Site\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Site\Entities\User;
use Modules\Site\Http\Traits\UserTrait;

use function App\Helpers\encryption;
use function App\Helpers\getStaff;
use function App\Helpers\ldap;
use function App\Helpers\randomString;

class UserController extends Controller
{
    use UserTrait;
    protected $baseView = 'site::users';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $roleNames = $user->getRoleNames();

        $limit = config('constants.pagination_records');
        $search = $request->has('q') ? $request->get('q') : null;
        $filter = $request->has('filter') ? $request->get('filter') : null;

        $role = null;
        if ($filter != null) {
            $role = Role::findByName($filter);
            $this->authorize('index', [User::class, $role]);
        }

        // get user list
        $users = User::with(['profile', 'roles'])->where(function ($query) use ($search) {
            if ($search != null) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
            }
        })->orderBy('created_at', 'asc')->paginate($limit);
        $users->setPath('');

        // get tab list and total users
        $roles = $this->calculateTabNumber();

        return $this->view([$this->baseView, 'index'], compact('users', 'roles', 'role'))
        ->with('title', __('Users'))
        ->with('i', ($request->input('page', 1) - 1) * $limit)
        ->with('q', $search)->with('filter', $filter);
    }

    protected function calculateTabNumber() {

        $getRoles = Role::orderBy('level', 'asc')->whereIn('name', config('constants.role_list'))->where('level', '>=', $this->getCurrentUserRoleLevel())->get();
        $sql = "SELECT c.id, c.name, COUNT(*) as total
                FROM sys_users a
                JOIN sys_model_has_roles b ON a.id = b.model_id
                JOIN sys_roles c ON c.id = b.role_id
                GROUP BY 1, 2";
        $totals = DB::select($sql);

        $roles = [];
        foreach ($getRoles as $key => $value) {
            $roles[$key]['name'] = $value->name;
            $roles[$key]['total'] = 0;
            foreach ($totals as $total) {
                if ($total->name == $value->name) {
                    $roles[$key]['total'] = $total->total;
                    break;
                }
            }
        }
        return $roles;
    }

    /**
     * Show current user login profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth()->user();
        return $this->view([$this->baseView, 'profile'], compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('level', 'asc')->whereIn('name', config('constants.role_list'))->where('level', '>=', $this->getCurrentUserRoleLevel())->get();
        return $this->view([$this->baseView, 'create'], compact('roles'));
    }
/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function store(Request $request)
    {
        if (env('HAS_CAS') == true || env('APP_CAS') == true) {
            $this->validate($request, [
                'email_id' => 'required',
                'roles' => 'required',
            ]);
            $input = $request->all();

            ## GET NO GAJI FROM EMAIL
            $ldap = ldap($request->email_id, 'um.edu.my');

            if ($ldap['status']) {
                $ldapBody = $ldap['body'];
                $content = getStaff(encryption('encrypt', $ldapBody->staffno));
                if ($content['status'] == true) {
                    $content = $content['body']->entry;

                    $user = User::find(['email' => $ldapBody->email])->first();

                    ## not allowed to insert if user already exists
                    if ($user) {
                        return redirect()->back()->with('toast_error', 'User already exist');
                    }
                    $user = new User();
                    $user->password = Hash::make(randomString());
                    $user->name = $content->fullname;
                    $user->email = $ldapBody->email;
                    $user->save();
                    $user->profile()->updateOrCreate(['user_id' => $user->id], [
                        'salary_no' => $content->salary_no,
                        'ic' => $content->ic_new ?? $content->passport_no,
                        'office_no' => $content->office_no,
                        'status' => $content->status->code,
                        'faculty_id' => $content->faculty->code,
                        'department_id' => $content->department->code,
                        'grade' => $content->position->code,
                        'grade_desc' => $content->position->desc,
                    ]);
        
                    if ($user->wasRecentlyCreated) {
                        $roles = $request->input('roles');
                        foreach ($roles as $role) {
                            $user->assignRole($role); 
                        }
                        
                        Log::info('Create new user ' . $user->staff_no);

                        return redirect()->route('site.users.index')->with('toast_success', 'User successfully added!!');
                    }
                }
                else {
                    // user not found in HRIS
                    return redirect()->back()->with('toast_error', 'User profile not found in HRIS');
                }
            }
            else {
                return redirect()->back()->with('toast_error', 'Problem with LDAP');
            }
        }
        else {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'same:confirm-password|required',
                'roles' => 'required',
            ]);

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $user->assignRole($request->input('roles'));
            return redirect()->route('site.users.index')
                ->with('toast_success', 'User created successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return $this->view([$this->baseView, 'show'], compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $this->authorize('edit', $user);

        $roles = Role::orderBy('level', 'asc')->where('level', '>=', $this->getCurrentUserRoleLevel())->get();
        $userRole = $user->roles->pluck('name')->all();
        return $this->view([$this->baseView, 'edit'], compact('user', 'roles', 'userRole'));
    }

    /**
     * Show the form for editing the current login user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfile()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name')->first();
        return $this->view([$this->baseView, 'edit_profile'], compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $id = auth()->user()->id;
        $user = auth()->user();
        if (env('HAS_CAS') == true || env('APP_CAS') == true) {
            $this->validate($request, [
                'hp_no' => 'required',
            ]);
            $input = $request->all();
            $user->profile()->update([
                'hp_no' => $request->hp_no,
            ]);
            // $user = User::find($id);
            // $user->update($input);

            return redirect()->route('site.users.profile')
                ->with('toast_success', 'User updated successfully');
        }
        else {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'same:confirm-password',
            ]);
            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                unset($input['password']);
            }
            $user = User::find($id);
            $user->update($input);
            $user->profile()->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->input('roles'));
            return redirect()->route('users.profile')
                ->with('toast_success', 'User updated successfully');
        }
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
        if (env('HAS_CAS') == true || env('APP_CAS') == true) {
            $this->validate($request, [
                'roles' => 'required',
            ]);
            $input = $request->all();
            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();

            $roles = $request->input('roles');
            foreach ($roles as $role) {
                $user->assignRole($role);
            }

            
            return redirect()->route('site.users.index')
                ->with('toast_success', 'User updated successfully');
        }
        else {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'same:confirm-password',
                'roles' => 'required',
            ]);
            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                unset($input['password']);
            }
            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->input('roles'));
            return redirect()->route('site.users.index')
                ->with('toast_success', 'User updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if ($user->id == $id) {
            return redirect()->route('site.users.index')->with('toast_warning', 'You are not allowed to delete yourself');
        }

        User::find($id)->delete();
        return redirect()->route('site.users.index')
            ->with('toast_success', 'User deleted successfully');
    }

    /**
     * Remove the specified resource from storage by batch.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function batchDestroy(Request $request) {
        $ids = $request->id;

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                User::find($id)->delete();
            }
            DB::commit();
            $status = true;
            $message = __("message.delete_success");
        }
        catch (Exception $e) {
            DB::rollback();
            $status = false;
            $message = __("message.delete_failed");
        }

        return response()->json([
            'status' => $status, 
            'message' => $message,
        ]);
    }

    public function login($id) {
        $oriUser = auth()->user();
        $user = User::find($id);

        session()->put('ori_user_id', $oriUser->id);
        Auth::loginUsingId($user->id);
        Log::info($oriUser->name . ' logged in as '.$user->name);
        return redirect()->route('home')->with('toast_success', 'You are currently logged in as ' . $user->name);
    }

    public function logout() {
        $oriUserId = session()->get('ori_user_id');
        $oriUser = User::find($oriUserId);
        $currUser = auth()->user();
        $user = User::find($currUser->id);
        Auth::loginUsingId($oriUserId);
        Log::info($user->name . ' change back to '.$oriUser->name);
        session()->remove('ori_user_id');
        session()->remove('meetingGroupID');
        session()->remove('meetingGroupName');
        return redirect()->route('site.users.index')->with('toast_success', 'logged out and logged in back to ' . $oriUser->name);
    }
}
