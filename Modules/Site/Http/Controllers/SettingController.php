<?php

namespace Modules\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Modules\Site\Entities\Setting;
use Modules\Site\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    protected $baseView = 'site::settings';

    /**
     * Display a listing of the resource and form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return $this->view([$this->baseView, 'index'], compact('settings'))->with('title', __('Settings'));
    }

    // saya tambah sini

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request) {
        $input = $request->all();

        // site name
        Config::set('settings.site_name', $input['site_name']);
        $siteName = Setting::where('key', 'site_name')->first();
        $siteName->update(['value' => $input['site_name']]);

        // google enable
        $valueGoogle = $request->has('google_enable') ? 'yes':'no';
        Config::set('settings.google_enable', $valueGoogle);
        $googleEnable = Setting::where('key', 'google_enable')->first();
        $googleEnable->update(['value' => $valueGoogle]);

        // cas enable
        $valueCas = $request->has('cas_enable') ? 'yes':'no';
        Config::set('settings.cas_enable', $valueCas);
        $casEnable = Setting::where('key', 'cas_enable')->first();
        $casEnable->update(['value' => $valueCas]);
        
        return back()->with('toast_success', __('message.update_success'));
    }
}
