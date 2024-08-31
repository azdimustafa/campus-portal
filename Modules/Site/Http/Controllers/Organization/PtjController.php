<?php

namespace Modules\Site\Http\Controllers\Organization;

use Modules\Site\Entities\Ptj;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Modules\Site\Entities\UserContext;
use Modules\Site\Http\Traits\OrgStructureTrait;

class PtjController extends Controller
{
    protected $baseView = 'site::organization.ptjs';

    /**
     * Display a treeview of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $search  = $request->has('q') ? $request->q : null;

        $ptjs = Ptj::when(($search != null), function ($query) use ($search) {
            return $query->where('name', 'like', '%'.$search.'%')->orWhere('name_my', 'like', '%'.$search.'%')->orWhere('code', 'like', '%'.$search.'%');
        })->oldest('name')->get();

        return $this->view([$this->baseView, 'index'], compact('ptjs'))
        ->with('title', __('PTj'))
        ->with('q', $search);
    }
}
