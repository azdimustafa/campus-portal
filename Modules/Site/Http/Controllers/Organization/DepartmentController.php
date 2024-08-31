<?php

namespace Modules\Site\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Site\Entities\Department;
use Modules\Site\Entities\Ptj;

class DepartmentController extends Controller
{
    protected $baseView = 'site::organization.departments';
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $ptjId = $request->has('ptj_id') ? $request->ptj_id : null;
        $search  = $request->has('q') ? $request->q : null;

        $ptjList = Ptj::oldest('name')->get()->pluck('name', 'id')->toArray();
        $departments = Department::when(($search != null), function ($query) use ($search) {
            return $query->where('name', 'like', '%'.$search.'%')->orWhere('name_my', 'like', '%'.$search.'%')->orWhere('code', 'like', '%'.$search.'%');
        })
        ->when(($ptjId != null), function ($query) use ($ptjId) {
            return $query->where('ptj_id', $ptjId);
        })
        ->oldest('name')->paginate(20);

        return $this->view([$this->baseView, 'index'], compact('departments', 'ptjList', 'ptjId'))
        ->with('title', __('Department'))
        ->with('q', $search);
    }
}
