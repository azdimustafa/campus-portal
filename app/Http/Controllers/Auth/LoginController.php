<?php

namespace App\Http\Controllers\Auth;

use App\Events\CreateOrUpdateUser;
use App\Events\LoginLog;
use Exception;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Modules\Site\Entities\LoginLog as EntitiesLoginLog;
use Modules\Site\Entities\User;
use Modules\Site\Entities\UserType;

use function App\Helpers\getStaffProfile;
use function App\Helpers\ldap;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('vendor.adminlte.auth.login');
    }


    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $google = Socialite::driver('google')->user();
            $email = $google->email;
            try {
                // call event to create or update user
                event(new CreateOrUpdateUser($email, $google->name, User::CREATED_BY_GOOGLE));
                $user = User::where('email', $email)->first();

                // login user
                auth()->login($user);

                // call event to log login activity | SUCCESS
                event(new LoginLog($user->email, User::CREATED_BY_GOOGLE, EntitiesLoginLog::LOGIN_SUCCESS, request()->server('REMOTE_ADDR')));
            }
            catch (Exception $e) {
                // call event to log login activity | FAILED
                event(new LoginLog($email, User::CREATED_BY_GOOGLE, EntitiesLoginLog::LOGIN_FAILED, request()->server('REMOTE_ADDR'), $e->getMessage()));
                return redirect()->route("home");
            }
            return redirect()->route("home");
        } catch (Exception $e) {
            // call event to log login activity | FAILED
            event(new LoginLog('', User::CREATED_BY_GOOGLE, EntitiesLoginLog::LOGIN_FAILED, request()->server('REMOTE_ADDR'), $e->getMessage()));
            return redirect('auth/google');
        }
    }
}
