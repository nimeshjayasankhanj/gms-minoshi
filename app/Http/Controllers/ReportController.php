<?php


namespace App\Http\Controllers;

use App\Invoice;
use App\MainCategory;
use App\MasterBooking;
use App\Product;
use App\Stock;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
        public function pendingOrdersIndex(Request $request){


            $orderID = $request['orderID'];
            $customer = $request['customer'];
            $date = $request['date'];
           
            $query = MasterBooking::query();
    
            
            if (!empty($orderID)) {
    
                $query = $query->where('idmaster_booking', $orderID);
            }
            if (!empty($customer)) {
    
                $query = $query->where('user_master_iduser_master', $customer);
            }
    

            if (!empty($date)) {
                $date = date('Y-m-d', strtotime($request['date']));
               
                $query = $query->where('date',$date);
            }
            
            $orders = $query->where('status', 0)->get();
            $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();

            return view('reports.pending-orders',['title'=>'Pending Orders','orders'=>$orders,'customers'=>$customers]);
        }

        public function incomeOrderIndex(Request $request){

            $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();
            
            
            $invoiceID = $request['invoiceID'];
            $orderID = $request['orderID'];
            $customer = $request['customer'];
            $date = $request['date'];
           
            $query = Invoice::query();
    
            if ($invoiceID) {
                $query = $query->where('idinvoice', $invoiceID);
            }
            if (!empty($orderID)) {
    
                $query = $query->where('master_booking_idmaster_booking', $orderID);
            }
            if (!empty($customer)) {
    
                $query = $query->where('customer', $customer);
            }
    

            if (!empty($date)) {
                $date = date('Y-m-d', strtotime($request['date']));
               
                $query = $query->where('date',$date);
            }
            
            $incomes = $query->where('status', 1)->get();
    
           
            return view('reports.income-report',['incomes'=>$incomes,'title'=>'Income Report','customers'=>$customers]);
        }

        public function acceptedOrdersIndex(Request $request){

            $orderID = $request['orderID'];
            $customer = $request['customer'];
            $date = $request['date'];
           
            $query = MasterBooking::query();
    
            
            if (!empty($orderID)) {
    
                $query = $query->where('idmaster_booking', $orderID);
            }
            if (!empty($customer)) {
    
                $query = $query->where('user_master_iduser_master', $customer);
            }
    

            if (!empty($date)) {
                $date = date('Y-m-d', strtotime($request['date']));
               
                $query = $query->where('date',$date);
            }
            
            $orders = $query->where('status', 1)->get();
       
            $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();

            return view('reports.accepted-orders',['title'=>'Accepted Orders','orders'=>$orders,'customers'=>$customers]);
        }

        public function completedOrdersIndex(Request $request){

            $orderID = $request['orderID'];
            $customer = $request['customer'];
            $date = $request['date'];
           
            $query = MasterBooking::query();
    
            
            if (!empty($orderID)) {
    
                $query = $query->where('idmaster_booking', $orderID);
            }
            if (!empty($customer)) {
    
                $query = $query->where('user_master_iduser_master', $customer);
            }
    

            if (!empty($date)) {
                $date = date('Y-m-d', strtotime($request['date']));
               
                $query = $query->where('date',$date);
            }
            
            $orders = $query->where('status', 2)->get();
       
            $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();

            return view('reports.completed-orders',['title'=>'Completed Orders','orders'=>$orders,'customers'=>$customers]);
        }

        public function activeStockIndex(Request $request){


            $productId = $request['productId'];
           
            $query = Stock::query();
    
            
            if (!empty($productId)) {
    
                $query = $query->where('product_idproduct', $productId);
            }
           
            
            $stocks = $query->where('status', 1)->get();
            
            $products=Product::where('status',1)->get();

            return view('reports.active-stock',['title'=>'Active Stock','stocks'=>$stocks,'products'=>$products]);
        }

        public function deactiveStockIndex(Request $request){

            $productId = $request['productId'];
           
            $query = Stock::query();
    
            
            if (!empty($productId)) {
    
                $query = $query->where('product_idproduct', $productId);
            }
           
            
            $stocks = $query->where('status', 0)->get();
            
            $products=Product::where('status',1)->get();

            return view('reports.deactive-stock',['title'=>'Deactive Stock','stocks'=>$stocks,'products'=>$products]);
        }


        
        


}