<?php
namespace App\Helpers;

use Exception;
use Modules\Site\Entities\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Modules\Site\Entities\Department;
use Modules\Site\Entities\Ptj;

if (!function_exists('camelCase')) {
    function camelCase($string) {
        $s = strtolower($string);

        $e = (strpos($s, ' ') !== false ? explode(' ', $s) : array($s));

        $keep_all_lowercase = array('or','and','but');

        foreach($e as $k=>$v)
        {
            if(!in_array($v, $keep_all_lowercase))
            {
                $str_split = str_split($v);

                foreach($str_split as $k2=>$v2)
                {
                    if(in_array($v2, range('a','z')))
                    {
                        $str_split[$k2] = strtoupper($v2);
                        break;
                    }
                }

                $e[$k] = implode('', $str_split);
            }
        }

        return implode(' ', $e);
        // return preg_replace_callback('#([a-zA-ZÄÜÖäüö0-9]+)#',function($a){
        //         return ucfirst(strtolower($a[0]));
        //     },
        //     $string
        // );
    }
}

if (!function_exists('convert_daterange')) {
    function convert_daterange($daterange) {

        $tmp = explode(' - ', $daterange);
        $start = str_replace('/', '-', $tmp[0]);
        $start = date('Y-m-d', strtotime($start));

        $end = str_replace('/', '-', $tmp[1]);
        $end = date('Y-m-d', strtotime($end));
        
        return [
            'start' => $start, 
            'end' => $end,
        ];
    }
}

if (!function_exists('formatBytes'))
{
    function formatBytes($bytes, $precision = 2) { 
        $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$precision}f", $bytes / pow(1024, $factor)) . ' ' .  @$size[$factor];
    } 
}

if (!function_exists('getUserIdWithCreate')) 
{
    function getUserIdWithCreate($email) {
        $user = User::where('email', $email)->first();
        if ($user) {
            return $user->id;
        }
        else {
            ## GET NO GAJI FROM EMAIL
            $tmp = explode('@', $email);
            $ldap = ldap($tmp[0], $tmp[1]);

            if ($ldap['status']) {
                $ldapBody = $ldap['body'];
                $content = getStaffProfile(encryption('encrypt', $ldapBody->staffno));
                if ($content['status'] == true) {
                    $content = $content['body']->entry;
                    $user = User::firstOrNew(['email' => $email]);
                    $user->password = Hash::make(randomString());
                    $user->name = $content->fullname;
                    $user->email = $email;
                    $user->save();

                    // get ptj id
                    $ptj = Ptj::where('code', $content->faculty->code)->first();

                    // get department id
                    $department = Department::where('code', $content->department->code)->first();

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
                        return $user->id;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
    }
}


if (!function_exists('getUser')) 
{
    function getUser($email) {
        $user = User::where('email', $email)->first();
        if ($user) {
            return $user;
        }
        else {
            ## GET NO GAJI FROM EMAIL
            $tmp = explode('@', $email);
            $ldap = ldap($tmp[0], $tmp[1]);

            if ($ldap['status']) {
                $ldapBody = $ldap['body'];
                $content = getStaffProfile(encryption('encrypt', $ldapBody->staffno));
                if ($content['status'] == true) {
                    $content = $content['body']->entry;
                    $user = User::firstOrNew(['email' => $email]);
                    $user->password = Hash::make(randomString());
                    $user->name = $content->fullname;
                    $user->email = $email;
                    $user->save();
                    // get ptj id
                    $ptj = Ptj::where('code', $content->faculty->code)->first();

                    // get department id
                    $department = Department::where('code', $content->department->code)->first();

                    $user->profile()->updateOrCreate(['user_id' => $user->id], [
                        'salary_no' => $content->salary_no,
                        'office_no' => $content->office_no,
                        'status' => $content->status->code,
                        'ptj_id' => $ptj->id,
                        'department_id' => $department->id,
                        'grade' => $content->position->code,
                        'grade_desc' => $content->position->desc,
                    ]);
                    return $user;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
    }
}

if (!function_exists('randomString')) 
{
    function randomString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('encryption')) {

    /**
     * Returns a encryption value
     *
     * @param string $action
     * Options (encrypt, decrypt)
     *
     * @param string $string
     * String need to be encrypt
     *
     * @return string a string encryption value
     *
     * */
    function encryption($action, $string)
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = "zB7m9HHzF6qPbm4F";
        $secret_iv = "S7NpzmCSEraunrWhurmw";

        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
}

if (!function_exists('getStaffProfile')) {

    /**
     * Returns a encryption value
     *
     * @param string $value
     * Options (encrypt, decrypt)
     *
     * @return array value from curl
     *
     * */
    function getStaffProfile($staffNo)
    {
        $encryptId = encryption('encrypt', $staffNo);
        $endpoint = "/hris/staff/profile/v3/$encryptId";
        $token = config('api.key');
        $url = config('api.url');

        try {
            $httpResponse = Http::withToken($token)->get($url . $endpoint);

            if ($httpResponse->successful()) {
                $response = $httpResponse->json();
                return $response;
            }
            else {
                $response = $httpResponse->json();
                return $response;
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}

// get student profile function
if (!function_exists('getStudentProfile')) {

    /**
     * Returns a encryption value
     *
     * @param string $value
     * Options (encrypt, decrypt)
     *
     * @return array value from curl
     *
     * */
    function getStudentProfile($studentCode)
    {
        $encryptId = encryption('encrypt', $studentCode);
        $endpoint = "/v4/student/profile/$encryptId";
        $token = config('api.key');
        $url = config('api.url');

        try {
            $httpResponse = Http::withToken($token)->get($url . $endpoint);
            

            if ($httpResponse->successful()) {
                $response = $httpResponse->json();
                return $response;
            }
            else {
                $response = $httpResponse->json();
                return $response;
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}

if (!function_exists('ldap')) {

    /**
     * Returns a encryption value
     *
     * @param string $value
     * Options (encrypt, decrypt)
     *
     * @return array value from curl
     *
     * */
    function ldap($username)
    {
        $endpoint = "/v2/ldap/search";
        $client = new \GuzzleHttp\Client();
        $token = config('api.key');
        $url = config('api.url');

        try {
            $response = $client->request('GET', $url . $endpoint, ['query' => ['search'=>$username], 'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ]]);
            $statusCode = $response->getStatusCode();
            $content = (string) $response->getBody();

            $jsonDecode = json_decode($content, true);

            if ($statusCode == 200) {
                return [
                    'status' => true,
                    'message' => '',
                    'body' => $jsonDecode['entry'],
                ];
            }

            return [
                'status' => false,
                'message' => 'Could not find the staff in LDAP',
            ];

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return [
                'status' => false,
                'message' => 'Error while calling LDAP',
                'error' => $e->getMessage()
            ];
        }
    }
}
