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
        public function index(){

          
            $Pending=MasterBooking::where('status',0)->sum('idmaster_booking');
            $accepted=MasterBooking::where('status',1)->sum('idmaster_booking');
            $completed=MasterBooking::where('status',2)->sum('idmaster_booking');

            return view('index',['title'=>'Dashboard','Pending'=>$Pending,'accepted'=>$accepted,'completed'=>$completed]);


        }    
}