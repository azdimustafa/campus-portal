<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MyMenuFilter implements FilterInterface
{
    public function transform($item)
    {
        // $item['restricted'] = true;

        if (Auth::check()) {
            if (isset($item['permission']) && auth()->user()->hasAnyRole($item['permission'])) {
                $item['restricted'] = false;
            }
        } else {
            if (isset($item['permission'])) {
                $item['restricted'] = true;
            }
        }

        return $item;
    }
}
