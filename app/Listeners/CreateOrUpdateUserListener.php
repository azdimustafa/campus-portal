<?php

namespace App\Listeners;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Site\Entities\Department;
use Modules\Site\Entities\Ptj;
use Modules\Site\Entities\User;
use Modules\Site\Entities\UserType;

use function App\Helpers\getStaffProfile;
use function App\Helpers\getStudentProfile;
use function App\Helpers\ldap;

class CreateOrUpdateUserListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = User::where('email', $event->email)->first();

        // explode email to array
        $email = explode('@', $event->email);

        if (count($email) != 2) {
            throw new Exception('Invalid email. Value must be in the form of <username>@<domain>');
        }

        $staffType = UserType::find(UserType::STAFF);
        $studentType = UserType::find(UserType::STUDENT);
        // if user email contains domain from $staffType

        if ($email[1] == $staffType->domain) {
            $this->isStaff($event->email, $event->from);
        }
        else if ($email[1] == $studentType->domain) {
            $this->isStudent($event->email, $event->from);
        }
        else {
            $this->isPublic($event->email, $event->name, $event->from);
        }
    }

    /**
     * Handling public user
     */
    protected function isPublic($email, $name, $from) {
        $dataUser['name'] = $name;
        $dataUser['email'] = $email;
        $dataUser['user_type_id'] = UserType::PUBLIC_USER;
        $dataUser['password'] = bcrypt(time().'-'.mt_rand());
        $dataUser['created_account_by'] = $from;
        $dataUser['updated_at'] = Carbon::now();

        $user = User::firstOrNew(['email' => $email]);
        $user->fill($dataUser);
        $user->save();

        // update profile
        $user->profile()->updateOrCreate(['user_id' => $user->id], ['salary_no' => '00000000']);

        $user->assignRole('NormalUser');
    }

    /**
     * Handling user that has student domain
     */
    protected function isStudent($email, $from) {
        $getLdap = ldap($email);

        // throw error bagi tak de body dalam rekod ldap. 
        if (count($getLdap['body']) == 0) {
            throw new Exception('#error1 : User not found in LDAP');
        }

        $ldapBody = $getLdap['body'][0];
        $studentCode = $ldapBody['studentcode'];

        // throw error bagi student yang tak de rekod studentcode dalam ldap
        if ($studentCode == '' || empty($studentCode)) {
            throw new Exception('#error2 : Student code not found in LDAP');
        }

        // get student profile from maya API
        $studentProfile = getStudentProfile($studentCode);

        if ($studentProfile['success'] == true) {
            $profile = $studentProfile['entry'];

            // create data user
            $dataUser['name'] = $profile['name'];
            $dataUser['email'] = $email;
            $dataUser['user_type_id'] = UserType::STUDENT;
            $dataUser['password'] = bcrypt(time().'-'.mt_rand());
            $dataUser['created_account_by'] = $from;
            $dataUser['updated_at'] = Carbon::now();

            $dataProfile['salary_no'] = $profile['stu_code'];

            $user = User::firstOrNew(['email' => $email]);
            $user->fill($dataUser);
            $user->save();

            $user->profile()->updateOrCreate(['user_id' => $user->id], $dataProfile);
            $user->assignRole('NormalUser');
        }
        else {
            throw new Exception('#error3 : Student profile not found in Maya API');
        }
    }

    /**
     * Handling user that has staff domain
     */
    protected function isStaff($email, $from) {
        $getLdap = ldap($email);

        if ($getLdap['status'] == true) {
            // throw error bagi tak de body dalam rekod ldap. 
            if (count($getLdap['body']) == 0) {
                throw new Exception('#error2 : User not found in LDAP');
            }

            $ldapBody = $getLdap['body'][0];
            $staffNo = $ldapBody['staffno'];

            // throw error bagi user yang ada rekod ldap. tetapi no gaji empty
            if ($staffNo == '' || empty($staffNo)) {
                throw new Exception('#error3 : Staff no not found in LDAP');
            }

            // get staff profile from hris
            $staffProfile = getStaffProfile($staffNo);

            // throw error bagi user yang ada rekod ldap. tetapi tak de rekod dalam HRIS
            if ($staffProfile['success'] == false) {
                throw new Exception('#error4 : Staff profile not found in HRIS');
            }

            $profile = $staffProfile['entry'];

            // create data user
            $dataUser['name'] = $profile['fullname'];
            $dataUser['email'] = $email;
            $dataUser['user_type_id'] = UserType::STAFF;
            $dataUser['password'] = bcrypt(time().'-'.mt_rand());
            $dataUser['created_account_by'] = $from;
            $dataUser['updated_at'] = Carbon::now();

            // create data user profile
            $dataProfile['salary_no'] = $profile['salary_no'];
            $dataProfile['office_no'] = $profile['office_no'];

            $ptjCode = $profile['faculty']['code'];
            $deptCode = $profile['department']['code'];

            if ($ptjCode != '' && $deptCode != '') {
                $ptj = Ptj::where('code', $ptjCode)->first();
                $dept = Department::where('code', $deptCode)->first();
                if ($ptj) {
                    $dataProfile['ptj_id'] = $ptj->id;
                }

                if ($dept) {
                    $dataProfile['department_id'] = $dept->id;
                }
            }

            // dd($profile, $dataUser, $dataProfile);
            $user = User::firstOrNew(['email' => $email]);
            $user->fill($dataUser);
            $user->save();

            $user->profile()->updateOrCreate(['user_id' => $user->id], $dataProfile);

            // by default all user will have role 'NormalUser'
            $user->assignRole('NormalUser');
        }
        else {
            throw new Exception('#error1 : User not found in LDAP');
        }
    }
}
