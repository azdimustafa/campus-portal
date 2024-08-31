<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Subfission\Cas\Facades\Cas;

class LogoutController extends Controller
{
    public function index() {
        if (Cas::isAuthenticated()) {
            cas()->logout();
        }
        auth()->logout();
        return view('logout');
    }

    public function cas() {
        if (Cas::isAuthenticated()) {
            cas()->logout();
        }
        else {
            return redirect()->route('logout');
        }
    }
}
