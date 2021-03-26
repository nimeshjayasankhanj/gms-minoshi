<?php
/**
 * Created by PhpStorm.
 * User: nimeshjayasankha
 * Date: 6/12/20
 * Time: 7:57 PM
 */

namespace App\Http\Controllers;


use App\Category;
use App\Measurement;
use App\POTempory;
use App\POTempoty;
use App\Product;
use App\PurchaseOrder;
use App\PurchaseOrderReg;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    

    public function addPoIndex(){

        $supplier=Supplier::where('status',1)->get();
        $categories=Category::where('status',1)->get();
        $products=Product::where('status',1)->get();
        return view('purchase_order.add-po',['title'=>'Purchase Order','categories'=>$categories,'suppliers'=>$supplier,'products'=>$products]);
    }

    public function pendingPoIndex(){

         $pendingPO=PurchaseOrder::where('status',0)->orderBy('created_at', 'desc')->get();
        
         
         return view('purchase_order.pending-po',['title'=>'Pending Purchase Order','pendingPO'=>$pendingPO]);

    }

    public function approvedPoIndex(){

        $approvedPO=PurchaseOrder::where('status',1)->orderBy('created_at', 'desc')->get();
        return view('purchase_order.approved-po',['title'=>'Approved Purchase Order','approvedPO'=>$approvedPO]);
    }

    public function completedPoIndex(){
       
        $completedPO=PurchaseOrder::where('status',2)->orderBy('created_at', 'desc')->get();
        return view('purchase_order.completed-po',['title'=>'Completed Purchase Order','completedPO'=>$completedPO]);
    }

    public function getPOTempTableData(){

        $viewAllPOTemps = POTempory::where('master_user_idmaster_user', Auth::user()->iduser_master)->where('status',1)->orderBy('created_at', 'desc')->paginate(10);

        $tableData = '';
        $total = 0;
        if (count($viewAllPOTemps) != 0) {
            foreach ($viewAllPOTemps as $viewAllPOTemp) {
                $total += $viewAllPOTemp->bp * $viewAllPOTemp->qty;
                $tableData .= "<tr>";
                $tableData .= "<td>" .$viewAllPOTemp->Product->product_name . "</td>";
                $tableData .= "<td>" . number_format($viewAllPOTemp->qty, 2) . "</td>";
                $tableData .= "<td style=\"text-align: right\">" . number_format($viewAllPOTemp->bp, 2) . "</td>";
                $tableData .= "<td style=\"text-align: right\">  " . number_format($viewAllPOTemp->bp * $viewAllPOTemp->qty, 2) . "</td>";
                $tableData .= "<td style='text-align: center'>";
                $tableData .= "<a class='btn btn-danger btn-sm'  data-id = '$viewAllPOTemp->idpo_tempory'  id = 'deletePO'  ><i style='color:white' class='fa fa-trash'></i></a >";
                $tableData .= " </td>";
                $tableData .= "</tr>";
            }

        } else {
            $tableData = "<tr><td colspan='8' style='text-align: center'><b>Sorry No Results Found.</b></td></tr>";

        }

        return response()->json(['total' => $total, 'tableData' => $tableData]);
    }

    public function getPOByID(Request $request){

        $poId=$request['poId'];
        $getPODetail=POTempory::find($poId);
        return response()->json($getPODetail);
    }

    public function saveTempPO(Request $request){

        $item = $request['item'];
        $qtyGrn = $request['qtyGrn'];
        $bPrice=$request['bPrice'];

        $rules = \Validator::make($request->all(), [


            'item' => 'required',
            'qtyGrn' => 'required||not_in:0',
            'bPrice' => 'required||not_in:0',

        ], [
            'item.required' => 'Product should be provided!',
            'qtyGrn.required' => 'Qty should be provided!',
            'qtyGrn.not_in' => 'Qty should be  more than 0!',
            'bPrice.required' => 'Buying Price should be provided!',
            'bPrice.not_in' => 'Buying Price should be  more than 0!',

        ]);
        if ($rules->fails()) {
            return response()->json(['errors' => $rules->errors()->all()]);
        }

        $isExist = POTempory::where('product_idproduct','=', $item)->where('master_user_idmaster_user','=', Auth::user()->iduser_master)
            ->where('status', 1)
            ->where('bp', '=',$bPrice)
            ->first();


        if ($isExist != null) {
            $isExist->qty += $qtyGrn;
            $isExist->save();
        } else {
            $POSave = new POTempory();
            $POSave->bp  = $bPrice;
            $POSave->qty = $qtyGrn;
            $POSave->product_idproduct = $item;
            $POSave->master_user_idmaster_user = Auth::user()->iduser_master;
            $POSave->status = '1';
            $POSave->save();
        }

        return response()->json(['success' => 'PO saved to table successfully']);
    }


    public function deleteTempPO(Request $request){

        $poId=$request['poId'];
        $deletePO=POTempory::find($poId);
        $deletePO->delete();
        return response()->json(['success' => 'PO deleted successfully']);
    }

    public function store(Request $request){

        $po=$request['po'];
        $supplier=$request['supplier'];
        $date= Carbon::now()->format('y/m/d');

        $rules = \Validator::make($request->all(), [

            'supplier' => 'required',

        ], [
          
            'supplier.required' => 'supplier should be provided!',

        ]);
        if ($rules->fails()) {
            return response()->json(['errors' => $rules->errors()->all()]);
        }

        $items = POTempory::where('status',1)->where('master_user_idmaster_user',Auth::user()->iduser_master)->get();
        $total = 0;
        foreach ($items as $item){
            $total += $item->bp * $item->qty;
        }

        $savePO=new PurchaseOrder();
        $savePO->user_master_iduser_master=Auth::user()->iduser_master;
        $savePO->supplier_idsupplier=$supplier;
        $savePO->total=$total;
        $savePO->date=$date;
        $savePO->status=0;
        $savePO->save();

        foreach ($items as $item){
            $savePOReg=new PurchaseOrderReg();
            $savePOReg->product_idproduct=$item->product_idproduct;
            $savePOReg->bp=$item->bp;
            $savePOReg->qty=$item->qty;
            $savePOReg->status=1;
            $savePOReg->purchase_order_idpurchase_order=$savePO->idpurchase_order;
            $savePOReg->save();
            $item->delete();
        }
        return response()->json(['success' => 'Purchase order saved successfully']);

    }


    public function getById(Request $request){

        $poId=$request['poId'];

        $POItems=PurchaseOrderReg::where('purchase_order_idpurchase_order',$poId)->orderBy('created_at', 'desc')->get();

        $tableData="";
        foreach ($POItems as $POItem){
            $tableData .= "<tr>";
            $category=Product::find($POItem->product_idproduct);
            $tableData .= "<td>" . Category::find($category->category_idcategory)->category_name . "</td>";
            $tableData .= "<td>" .Product::find($POItem->product_idproduct)->product_name . "</td>";
            $tableData .= "<td>" . number_format($POItem->qty,2). "</td>";
            $tableData .= "<td style='text-align: right'>" . number_format($POItem->bp,2). "</td>";
            $tableData .= "<tr>";

            return response()->json(['tableData' => $tableData]);
        }
    }

    public function approvedPO(Request $request){

        $id=$request['id'];
        $approvedPO=PurchaseOrder::find($id);
        $approvedPO->status=1;
        $approvedPO->save();

     
        return response()->json(['success' => 'PO approved successfully']);
    }

    


    

    


}