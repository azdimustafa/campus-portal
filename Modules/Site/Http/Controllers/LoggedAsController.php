<?php
namespace Modules\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Modules\Site\Entities\User;

use function App\Helpers\getUserIdWithCreate;

class LoggedAsController extends Controller
{
    protected $baseView = 'modules.superadmin.logged-as';

    public function index(Request $request) {
        $limit = config('constants.pagination_records');
        $search = $request->has('q') ? $request->get('q') : null;;
        // get user list
        $users = User::where(function ($query) use ($search) {
            if ($search != null) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
            }
        })->orderBy('created_at', 'desc')->paginate($limit);
        $users->setPath('');

        return $this->view([$this->baseView, 'index'], compact('users'))->with('i', ($request->input('page', 1) - 1) * $limit)->with('q', $search);
    }

    public function login($id) {
        $oriUser = auth()->user();
        $user = User::find($id);

        // getUserIdWithCreate($user->email);
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
