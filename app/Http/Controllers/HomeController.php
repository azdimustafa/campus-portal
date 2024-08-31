<?php

namespace App\Http\Controllers;

use App\Events\CreateOrUpdateUser;
use Auth;
use App\Http\Traits\HomeTrait;
use App\Mail\MailMeetingCancellation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Modules\Site\Entities\User;
use Spatie\GoogleCalendar\Event;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!auth()->guest()) {
            
            return view('home');
        }
        return view('welcome');
    } ## END function index()
} ## END class HomeController
