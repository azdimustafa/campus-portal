<?php

namespace App\Http\Controllers\Misc;

use App\Http\Controllers\Controller;
use Modules\Site\Entities\Section;
use Modules\Site\Entities\Division;
use Modules\Site\Entities\Department;
use Modules\Site\Entities\Menu;
use Modules\Site\Entities\Permission;
use Modules\Site\Entities\Ptj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SelectController extends Controller
{
    /**
     * Display a listing of the faculties for select dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFaculties(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $results = Ptj::orderby('name', 'asc')->select('id', 'name', 'short_name')->get();
        } else {
            $results = Ptj::orderby('name', 'asc')
                        ->select('id', 'name', 'short_name')
                        ->where(function ($query) use ($search) {
                            if ($search != null) {
                                $query->orWhere('short_name', 'like', '%' . $search . '%');
                                $query->orWhere('name', 'like', '%' . $search . '%');
                            }
                        })
                        ->get();
        }

        $response = array();
        foreach ($results as $result) {
            $response[] = array(
                "id" => $result->id,
                "text" => $result->name,
            );
        }

        echo json_encode($response);
        exit;
    }
    
    /**
     * Display a listing of the menus for select dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getMenus(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $results = Menu::isParent()->orderby('text', 'asc')->select('id', 'text')->get();
        } else {
            $results = Menu::isParent()->orderby('text', 'asc')->select('id', 'text')->where('text', 'like', '%' . $search . '%')->get();
        }

        $response = array();
        foreach ($results as $result) {
            $response[] = array(
                "id" => $result->id,
                "text" => $result->text,
            );
        }

        echo json_encode($response);
        exit;
    }

    /**
     * Display a listing of the permissions for select dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPermissions(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $results = Permission::whereNull('parent_id')->orderby('name', 'asc')->select('id', 'name')->get();
        } else {
            $results = Permission::whereNull('parent_id')->orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->get();
        }

        $response = array();
        foreach ($results as $result) {
            $response[] = array(
                "id" => $result->id,
                "text" => $result->name,
            );
        }

        echo json_encode($response);
        exit;
    }

    

    /**
     * Display a listing of the departments for select dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDepartments(Request $request, $id)
    {
        $search = $request->search;

        if (App::isLocale('en')) {
            if ($search == '') {
                $results = Department::where('ptj_id', $id)->orderby('name', 'asc')->select('id', 'name', 'short_name')->get();
            } else {
                $results = Department::where('ptj_id', $id)->orderby('name', 'asc')
                            ->select('id', 'name', 'short_name')
                            ->where(function ($query) use ($search) {
                                if ($search != null) {
                                    $query->orWhere('name', 'like', '%' . $search . '%');
                                }
                            })
                            ->get();
            }

            $response = array();
            foreach ($results as $result) {
                $response[] = array(
                    "id" => $result->id,
                    "text" => $result->name,
                );
            }
        }
        else {
            if ($search == '') {
                $results = Department::where('ptj_id', $id)->orderby('name_my', 'asc')->select('id', 'name_my', 'short_name')->get();
            } else {
                $results = Department::where('ptj_id', $id)->orderby('name_my', 'asc')
                            ->select('id', 'name_my', 'short_name')
                            ->where(function ($query) use ($search) {
                                if ($search != null) {
                                    $query->orWhere('name_my', 'like', '%' . $search . '%');
                                }
                            })
                            ->get();
            }

            $response = array();
            foreach ($results as $result) {
                $response[] = array(
                    "id" => $result->id,
                    "text" => $result->name_my,
                );
            }
        }   



        echo json_encode($response);
        exit;
    }

    /**
     * Display a listing of the divisions for select dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDivisions(Request $request, $id)
    {
        $search = $request->search;

        if ($search == '') {
            $results = Division::where('department_id', $id)->orderby('name', 'asc')->select('id', 'name')->get();
        } else {
            $results = Division::where('department_id', $id)->orderby('name', 'asc')
                        ->select('id', 'name')
                        ->where(function ($query) use ($search) {
                            if ($search != null) {
                                $query->orWhere('name', 'like', '%' . $search . '%');
                            }
                        })
                        ->get();
        }

        $response = array();
        foreach ($results as $result) {
            $response[] = array(
                "id" => $result->id,
                "text" => $result->name,
            );
        }

        echo json_encode($response);
        exit;
    }

    /**
     * Display a listing of the sections for select dropdown.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSections(Request $request, $id)
    {
        $search = $request->search;

        if ($search == '') {
            $results = Section::where('division_id', $id)->orderby('name', 'asc')->select('id', 'name')->get();
        } else {
            $results = Section::where('division_id', $id)->orderby('name', 'asc')
                        ->select('id', 'name')
                        ->where(function ($query) use ($search) {
                            if ($search != null) {
                                $query->orWhere('name', 'like', '%' . $search . '%');
                            }
                        })
                        ->get();
        }

        $response = array();
        foreach ($results as $result) {
            $response[] = array(
                "id" => $result->id,
                "text" => $result->name,
            );
        }

        echo json_encode($response);
        exit;
    }
}
