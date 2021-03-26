<?php


namespace App\Http\Controllers;

use App\BookingReg;
use App\Category;
use App\CategoryPrice;
use App\Invoice;
use App\ItemInvReg;
use Carbon\Carbon;
use App\ItemInvTemp;
use App\MainCategory;
use App\MasterBooking;
use App\Payment;
use App\Product;
use App\Stock;
use App\TempBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{

    public function invoiceHistoryIndex(){

        $invoiceDetails=Invoice::where('status',1)->latest()->get();

        
        return view('invoice.invoice-history',['title'=>'Invoice History','invoiceDetails'=>$invoiceDetails]);
    }


    
    public function saveInvoice(Request $request){

        $paymentAmount=$request['paymentAmount'];

        $bookingDetail=MasterBooking::find($request['idOrder']);
        $systemDate = Carbon::now()->format('y/m/d');

      
            $validator = \Validator::make($request->all(), [

                'paymentAmount' => 'required',
               
            ], [
                'paymentAmount.required' => 'Payment Amount should be provided!',
               
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }

        if($paymentAmount<$bookingDetail->total){
            return response()->json(['errorsAmount' =>'Paid Amount must be eqal to total cost']);
        }
    
        $save=new Invoice();
        $save->invoice_total=$bookingDetail->total;
        $save->customer=$bookingDetail->user_master_iduser_master;
        $save->date=$systemDate;
        $save->master_booking_idmaster_booking=$request['idOrder'];
        $save->status=1;
        if($paymentAmount!=null){
            $save->balance=$paymentAmount-$bookingDetail->total;
        }
        $save->paid=$paymentAmount;
       
        $save->save();


        $booking=MasterBooking::find($request['idOrder']);
        $booking->status=2;
        $booking->save();

        $items=BookingReg::where('master_booking_idmaster_booking',$request['idOrder'])->get();
        
        foreach($items as $item){
            $saveItem=new ItemInvReg();
            $saveItem->qty=$item->qty;
            $saveItem->status=1;
            $saveItem->product_idproduct=$item->product_idproduct;
            $saveItem->invoice_idinvoice=$save->idinvoice;
            $saveItem->save();

        }
        
        $savePayment=new Payment();
        $savePayment->base=2;
        $savePayment->id=$save->idinvoice;
        $savePayment->totalAmount=$bookingDetail->total;
        $savePayment->cash=$paymentAmount;
        $savePayment->status=1;
        $savePayment->save();


        return \response()->json(['success'=>'Invoice saved successfully']);
    }


    public function getInvoiceItems(Request $request){

        $invId = $request['invId'];

        $getItemDetails = ItemInvReg::where('invoice_idinvoice', $invId)->orderBy('created_at', 'desc')->where('status', 1)->get();
        $tableData = '';

        foreach ($getItemDetails as $getItemDetail) {
            $tableData .= "<tr>";
            $tableData .= "<td>" . $getItemDetail->Product->product_name . "</td>";
            $tableData .= "<td >" . number_format($getItemDetail->qty, 2) . "</td>";
            $tableData .= "</tr>";
        }
        return response()->json(['tableData' => $tableData]);
    }
    public function printInvoice($id)
    {
        $invoice = Invoice::find(intval($id));

        return view('print.print-invoice')->with(["invoice" => $invoice]);
    }


}