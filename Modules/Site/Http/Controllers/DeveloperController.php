<?php

namespace Modules\Site\Http\Controllers;

use Modules\Site\Entities\Ptj;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Modules\Site\Entities\UserContext;
use Modules\Site\Http\Traits\OrgStructureTrait;

class DeveloperController extends Controller
{
    protected $baseView = 'site::developers';

    /**
     * Display naming convention do and dont.
     *
     * @return \Illuminate\Http\Response
     */
    public function namingConvention(Request $request) {
        return $this->view([$this->baseView, 'naming_convention'])->with('title', __('Naming Conventions'));
    }

    /**
     * How to enable model audit.
     *
     * @return \Illuminate\Http\Response
     */
    public function modelAudit(Request $request) {
        return $this->view([$this->baseView, 'model_audit'])->with('title', __('Model Audit'));
    }

    /**
     * Example to set route name.
     * 
     * @return \Illuminate\Http\Response
     */
    public function routeName(Request $request) {
        return $this->view([$this->baseView, 'route_name'])->with('title', __('Route Name'));
    }

    /**
     * Other example.
     * 
     * @return \Illuminate\Http\Response
     */
    public function otherExample(Request $request) {
        return $this->view([$this->baseView, 'other_example'])->with('title', __('Other Example'));
    }

    /**
     * Example do and dont.
     * 
     * @return \Illuminate\Http\Response
     */
    public function doDont(Request $request) {
        return $this->view([$this->baseView, 'do_dont'])->with('title', __('Do & Dont'));
    }

    /**
     * Example form input.
     * 
     * @return \Illuminate\Http\Response
     */
    public function formInput(Request $request) {
        
        return $this->view([$this->baseView, 'form_input'])->with('title', __('Form Input'));
    }

    /**
     * Example form input.
     * 
     * @return \Illuminate\Http\Response
     */
    public function submitFormInput(Request $request) {
        $request->validate([
            'input_name' => 'required|max:5',
        ]);
        return back();
    }
}
