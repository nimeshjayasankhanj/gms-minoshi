<?php


namespace App\Http\Controllers;

use App\MainCategory;
use App\MasterBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
        public function pendingTasks(){

            $assignWorks=MasterBooking::where('status',2)->where('driver',Auth::user()->iduser_master)->get();
            return view('driver_task.pending-tasks',['title'=>'Pending Tasks','assignWorks'=>$assignWorks]);
        }
        public function completedTasks(){

           
            $assignWorks=MasterBooking::where('status',3)->where('driver',Auth::user()->iduser_master)->get();
            

            return view('driver_task.completed-tasks',['title'=>'Complted Task','assignWorks'=>$assignWorks]);
        }
        
        public function deliveredOrder(Request $request){

            $id=$request['id'];
            $changeStatus=MasterBooking::find($id);
            $changeStatus->status=3;
            $changeStatus->save();

            return response()->json(['success'=>'Develiered successfully.']);
        }
     

}