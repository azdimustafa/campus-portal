<?php

namespace App\Http\Controllers\Misc;

use App\Http\Controllers\Controller;
use function App\Helpers\encryption;
use function App\Helpers\getStaff;
use function App\Helpers\ldap;
use Illuminate\Http\Request;
use Modules\Site\Entities\User;

class AjaxController extends Controller
{
    /**
     * Display a listing of the departments for select dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getStaff(Request $request)
    {
        $id = $request->id;
        $ldap = ldap($id, 'um.edu.my');

        if ($ldap['status'] == true) {
            $ldapBody = $ldap['body'];
            $content = getStaff(encryption('encrypt', $ldapBody->staffno));

            if ($content['status'] == true) {
                $response = $content['body']->entry;
                return response()->json([
                    'status' => true, 
                    'message' => '', 
                    'body' => $response, 
                ]);
            }           
        }

        return response()->json([
            'status' => false, 
            'message' => 'Staff not found'
        ]);
    }
    // public function getStaff(Request $request)
    // {
    //     $id = $request->id;
    //     $encrypt = encryption('encrypt', $id);

    //     $content = getStaff($encrypt);
    //     return json_encode($content);
    //     exit;
    // }

    /**
     * Autocomplete search user
     */
    public function searchUser(Request $request) {
        $term = $request->get('term');
        $limit = config('constants.pagination_records');
        $users = User::with(['faculty','department'])->where(function ($query) use ($term) {
            if ($term != null) {
                $query->where('name', 'like', '%' . $term . '%');
                $query->orWhere('email', 'like', '%' . $term . '%');
            }
        })->orderBy('name', 'asc')->limit($limit)->get();

        $response = [];
        foreach ($users as $k => $user) {
            $response[$k]['id'] = $user->id;
            $response[$k]['name'] = $user->name;
            $response[$k]['desc'] = $user->email;
        }

        return response()->json($response);
    }
}
