<?php


namespace App\Http\Controllers;

use App\BookingReg;
use App\CategoryPrice;
use App\Mail\PendingOrder;
use App\MainCategory;
use App\MasterBooking;
use App\TempBooking;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index()
    {

        if (Auth::user()->user_role_iduser_role == 2) {
            $Pending = MasterBooking::where('status', 0)->where('user_master_iduser_master', Auth::user()->iduser_master)->count('idmaster_booking');
            $accepted = MasterBooking::where('status', 1)->where('user_master_iduser_master', Auth::user()->iduser_master)->count('idmaster_booking');
            $completed = MasterBooking::where('status', 2)->where('user_master_iduser_master', Auth::user()->iduser_master)->count('idmaster_booking');

            return view('index', ['title' => 'Dashboard', 'Pending' => $Pending, 'accepted' => $accepted, 'completed' => $completed]);
        } else if (Auth::user()->user_role_iduser_role == 1) {
            $Pending = MasterBooking::where('status', 0)->count('idmaster_booking');
            $accepted = MasterBooking::where('status', 1)->count('idmaster_booking');
            $completed = MasterBooking::where('status', 2)->count('idmaster_booking');

            return view('index', ['title' => 'Dashboard', 'Pending' => $Pending, 'accepted' => $accepted, 'completed' => $completed]);
        } else if (Auth::user()->user_role_iduser_role == 3) {
            $Pending = MasterBooking::where('status', 0)->count('idmaster_booking');
            $accepted = MasterBooking::where('status', 1)->count('idmaster_booking');
            $completed = MasterBooking::where('status', 2)->count('idmaster_booking');

            return view('index', ['title' => 'Dashboard', 'Pending' => $Pending, 'accepted' => $accepted, 'completed' => $completed]);
        }
    }
}
