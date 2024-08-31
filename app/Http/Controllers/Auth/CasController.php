<?php

namespace App\Http\Controllers\Auth;

use App\Events\CreateOrUpdateUser;
use App\Events\LoginLog;
use App\Events\ManageUserLocal;
use Subfission\Cas\Facades\Cas;
use function App\Helpers\ldap;
use App\Http\Controllers\Controller;
use Modules\Site\Entities\LoginLog as EntitiesLoginLog;
use Modules\Site\Entities\User;

class CasController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Cas::authenticate();

        // get email from cas authentication
        $email = Cas::getUser();

        // call event to create or update user
        event(new CreateOrUpdateUser($email, '', User::CREATED_BY_CAS));
        $user = User::where('email', $email)->first();

        // login user
        auth()->login($user);

        // call event to log login activity
        event(new LoginLog($email, User::CREATED_BY_CAS, EntitiesLoginLog::LOGIN_SUCCESS, request()->server('REMOTE_ADDR')));
        return redirect()->route("home");
    }

    public function authenticated() {
        if (!Cas::isAuthenticated())
            return view('authenticated');
            // Cas::authenticate();
        return view('authenticated');
    }

    public function logout() {
        if (Cas::isAuthenticated()) {
            cas()->logout();
        }
        auth()->logout();
        return view('logout');
    }
}
