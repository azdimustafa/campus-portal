<?php

namespace App\Listeners;

use App\Events\LoginHistory;
use App\Events\ManageUserLocal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use function App\Helpers\encryption;
use function App\Helpers\getStaff;
use function App\Helpers\randomString;

use Modules\Site\Entities\User as UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Site\Entities\Department;
use Modules\Site\Entities\Ptj;

class StoreUserLocal
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ManageUserLocal  $event
     * @return void
     */
    public function handle(ManageUserLocal $event)
    {
        $content = getStaff(encryption('encrypt', $event->staffNo));
        if ($content['status'] == true) {
            $content = $content['body']->entry;
            $user = UserModel::firstOrNew(['email' => $event->email]);
            $user->password = Hash::make(randomString());
            $user->name = $content->fullname;
            $user->email = $event->email;
            $user->save();

            // get ptj id
            $ptj = Ptj::where('code', $content->faculty->code)->first();
            
            // get department id
            $department = Department::where('code', $content->department->code)->first();

            // store user profile
            $user->profile()->updateOrCreate(['user_id' => $user->id], [
                'salary_no' => $content->salary_no,
                'office_no' => $content->office_no,
                'status' => $content->status->code,
                'ptj_id' => $ptj->id,
                'department_id' => $department->id,
                'grade' => $content->position->code,
                'grade_desc' => $content->position->desc,
            ]);

            if ($user->wasRecentlyCreated) {
                Log::info('Assign role Public to ' . $user->staff_no);
            }
            $user->assignRole([config('constants.role.normalUser')]);
            Auth::loginUsingId($user->id);
            Log::info('Showing the user profile for user: '.$user->id);
            // event(new LoginHistory($user));
            return true;
        }
        else {
            return false;
        }
    }
}
