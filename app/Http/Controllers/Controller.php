<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $model;
    protected $baseRoute;
    protected $baseView;
    protected $resourceName;
    protected $pageHeaderText;

    public function __construct()
    {

        if (request()->exists('debug')) {
            config(['app.debug' => true]);
        }

        view()->share([
            'baseRoute' => $this->baseRoute,
            'baseView' => $this->baseView,
            'resourceName' => $this->resourceName,
            'pageHeaderText' => $this->pageHeaderText,
        ]);
    }
    protected function view($view = null, $data = [], $mergeData = [])
    {
        $factory = app(ViewFactory::class);

        if (0 === func_num_args()) {
            return $factory;
        }

        if (is_array($view)) {
            $view = implode('.', $view);
        }

        return $factory->make($view, $data, $mergeData);
    }
}
