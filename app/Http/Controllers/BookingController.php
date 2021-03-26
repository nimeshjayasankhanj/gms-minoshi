<?php


namespace App\Http\Controllers;

use App\BookingReg;
use App\ItemInvTemp;
use App\MainCategory;
use App\MasterBooking;
use App\Product;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
        public function pendingWorksIndex(){

            $pendingBooking=MasterBooking::where('status',0)->get();

            return view('tasks.pending-works',['title'=>'Pending Works','pendingBooking'=>$pendingBooking]);
        }

        public function viewItemList(Request $request){

            $bookingId=$request['bookingId'];

            $getDetails = BookingReg::where('master_booking_idmaster_booking', $bookingId)->orderBy('created_at', 'desc')->where('status', 1)->get();
            $tableData = '';

        foreach ($getDetails as $getDetail) {
            $tableData .= "<tr>";
            
            $product=Product::find($getDetail->product_idproduct);
            $tableData .= "<td >" . $product->product_name. "</td>";
            $tableData .= "<td>" . $getDetail->qty . "</td>";
            $tableData .= "</tr>";
        }
        return response()->json(['tableData' => $tableData]);
        }

        public function approvedOrder(Request $request){

            $updateStatus=MasterBooking::find($request['id']);
            $updateStatus->status=1;
            $updateStatus->save();

            return response()->json(['success'=>'Booking approved successfully']);
        }

        public function acceptedWorksIndex(){

            $acceptedBooking=MasterBooking::where('status',1)->get();

            return view('tasks.accepted-works',['title'=>'Accepted Works','acceptedBooking'=>$acceptedBooking]);
     
        }

        public function completedOrder(Request $request){

            $updateStatus=MasterBooking::find($request['id']);
            $updateStatus->status=2;
            $updateStatus->save();

            return response()->json(['success'=>'Booking Completed successfully']);
        }


        public function completeWorksIndex(){

            $completedBooking=MasterBooking::where('status',2)->get();

            return view('tasks.completed-works',['title'=>'Completed Works','completedBooking'=>$completedBooking]);
     
        }

        public function generateBarCode(Request $request){

            $bookigId=$request['bookigId'];

            $generateCode=MasterBooking::find($bookigId);
            $generateCode->barcode=str_pad($bookigId,5,'0',STR_PAD_LEFT) .''.rand(1,50000000) ; 
            $generateCode->save();

            
        }

        public function generateInvoiceIndex(Request $request){

            
            $idOrder=$request['idOrder'];
            $bookingDetail=MasterBooking::find($request['idOrder']);
            $bookingItems=BookingReg::where('master_booking_idmaster_booking',$idOrder)->get();

            return view('invoice.generate-invoice',['idOrder'=>$idOrder,'bookingItems'=>$bookingItems,'title'=>'Generate Invoice','idOrder'=>$idOrder,'bookingDetail'=>$bookingDetail])->render();
        }

        public function getAvailableQty(Request $request){

            
            $itemId=$request['itemId'];
            $getQty=Stock::where('product_idproduct',$itemId)->where('status',1)->sum('qty_available');

            if($itemId!=null){
                $temFIles=ItemInvTemp::where('status',1)->where('user_master_iduser_master',Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
      
                foreach ($temFIles as $temFIle) {
                   
                    $getQty-=$temFIle->qty;
                }
                
                return $getQty;
            }
            
        }

        public function printBarcode($id){

            $booking = MasterBooking::find(intval($id));

        return view('print.print-booking')->with(["booking" => $booking]);
        }

}