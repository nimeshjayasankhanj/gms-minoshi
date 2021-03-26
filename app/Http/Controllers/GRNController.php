<?php


namespace App\Http\Controllers;


use App\BankPayment;
use App\BankPaymentTemp;
use App\Category;
use App\ChequePayment;
use App\ChequePaymentTemp;
use App\GRNItemTemp;
use App\GrnQty;
use App\GRNTemp;
use App\MasterGrn;
use App\Measurement;
use App\MetaPayment;
use App\Payment;
use App\PettyCash;
use App\Product;
use App\PurchaseOrder;
use App\PurchaseOrderReg;
use App\Stock;
use App\Store;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GRNController extends Controller
{
    public function addGrnIndex(){

        $paymentTypes=MetaPayment::where('grn',1)->get();
        $suppliers=Supplier::where('status',1)->get();
        $categories=Category::where('status',1)->get();

        $purchaseOrders=PurchaseOrder::where('status',1)->get();
        return view('grn.add-grn',['title'=>'Add GRN','categories'=>$categories,'suppliers'=>$suppliers,'paymentTypes'=>$paymentTypes,'purchaseOrders'=>$purchaseOrders]);
    }

    public function grnHistoryIndex(){

        $suppliers=Supplier::where('status',1)->get();
        $grnHistories=MasterGrn::where('status',1)->orderBy('created_at', 'desc')->paginate(10);
        return view('grn.grn-history',['title'=>'GRN History','grnHistories'=>$grnHistories,'suppliers'=>$suppliers]);
    }

    public function getProducts(Request $request){

        $categoryId=$request['categoryId'];

        $products=Product::where('status',1)->where('master_company',Auth::user()->master_company)->where('category_idcategory',$categoryId)->get();
        $options="";
        $options .= "<option value='' selected disabled>" . 'Select Product'. "</option>";
        foreach ($products as $product) {
            $options .= "<option value='" . $product->idproduct . "'>" .$product->item_name . "</option>";
        }
        return response()->json($options);
    }
    public function getTempTableData(){

        $viewAllGrnTemps = GRNTemp::where('master_user_idmaster_user', Auth::user()->iduser_master)->orderBy('created_at', 'desc')->paginate(10);
        $poId = GRNTemp::where('master_user_idmaster_user', Auth::user()->iduser_master)->first();

        if ($poId!=null){
            $getPO=PurchaseOrder::find($poId->purchase_order);
        }else{
            $getPO=null;
        }

        $tableData = '';
        $total=0;
        if (count($viewAllGrnTemps) != 0) {
            foreach ($viewAllGrnTemps as $viewAllGrnTemp) {

                $total += $viewAllGrnTemp->buying_price * $viewAllGrnTemp->qty;
                $tableData .= "<tr>";
                $tableData .= "<td>" . $viewAllGrnTemp->Product->product_name . "</td>";
              
                $tableData .= "<td>" . number_format($viewAllGrnTemp->qty, 2)."</td>";
                $tableData .= "<td style=\"text-align: right\">" . number_format($viewAllGrnTemp->buying_price, 2) . "</td>";
                $tableData .= "<td style=\"text-align: right\">  " . number_format($viewAllGrnTemp->buying_price * $viewAllGrnTemp->qty, 2) . "</td>";
                $tableData .= "<td style='text-align: center'>";
                $tableData .= "<button type='button'  class='btn btn-sm btn-warning  waves-effect waves-light'  data-target=\"#updateItemModal\" data-toggle=\"modal\"   data-id='$viewAllGrnTemp->idgrn_temp'   id='editGrn' > ";
                $tableData .= " <i class=\"fa fa-edit\"></i>";
                $tableData .= "  </button>";
                $tableData .= " </td>";
                $tableData .= "</tr>";
            }

        } else {
            $tableData = "<tr><td colspan='8' style='text-align: center'><b>Sorry No Results Found.</b></td></tr>";

        }

        return response()->json(['total' => $total, 'tableData' => $tableData,'getPO'=>$getPO]);

    }

    public function tempStore(Request $request)
    {

        $item = $request['item'];
        $qtyGrn = $request['qtyGrn'];
        $category = $request['category'];

        $bPrice=Product::find($item);

        $rules = \Validator::make($request->all(), [

            'category' => 'required',
            'item' => 'required',
            'qtyGrn' => 'required||not_in:0',

        ], [
            'item.required' => 'Product should be provided!',
            'category.required' => 'Category should be provided!',
            'qtyGrn.required' => 'Qty should be provided!',
            'qtyGrn.not_in' => 'Qty should be  more than 0!',

        ]);
        if ($rules->fails()) {
            return response()->json(['errors' => $rules->errors()->all()]);
        }

            $isExist = GRNTemp::where('product_idproduct','=', $item)->where('master_user_idmaster_user','=', Auth::user()->idmaster_user)
            ->where('status', 1)
                ->where('buying_price', '=',$bPrice->buying_price)
                ->where('category_idcategory', '=', $category)
                ->first();


        if ($isExist != null) {
            $isExist->qty += $qtyGrn;
            $isExist->save();
        } else {
            $grnTempSave = new GRNTemp();
            $grnTempSave->buying_price = $bPrice->buying_price;
            $grnTempSave->qty = $qtyGrn;
            $grnTempSave->product_idproduct = $item;
            $grnTempSave->category_idcategory = $category;
            $grnTempSave->master_user_idmaster_user = Auth::user()->idmaster_user;
            $grnTempSave->status = '1';
            $grnTempSave->save();
        }

        return response()->json(['success' => 'Products added to table successfully']);
    }

    public function deleteGrnTemp(Request $request)
    {
        $dGrnId = $request['dGrnId'];
        $grnDelete= GRNTemp::find($dGrnId);
        if ($grnDelete!=null){
            $grnDelete->delete();
        }
        return response()->json(['success' => 'Products deleted successfully']);
    }

    public function store(Request $request)
    {

        $PoNoId=$request['poNo'];
        $discount = $request['discount'];
        $paymentType = $request['paymentType'];
        $paid = $request['paid'];
        $bankId = $request['bankId'];
        $bankAccountNo = $request['bankAccountNo'];
        $bankAccount = $request['bankAccount'];
        $discountType = $request['discountType'];
        $systemDate = Carbon::now()->format('y/m/d');
        $visaBill=$request['visaBill'];
        $cardAmount=$request['cardAmount'];


            $validator = \Validator::make($request->all(), [

                'paymentType' => 'required',
            ], [
                'paymentType.required' => 'Payment Type should be provided!',

            ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $totalPrice = 0;
        $grnItemPrices = GRNTemp::where('master_user_idmaster_user', Auth::user()->iduser_master)->get();

        foreach ($grnItemPrices as $grnItemPrice) {
            $totalPrice += $grnItemPrice->qty * $grnItemPrice->buying_price;
        }

        if ($discountType == 1) {
            $discount = floatval($totalPrice) * floatval($discount);
            $netTotal = floatval($totalPrice) - floatval($discount);
        } else {

            $netTotal = floatval($totalPrice) - floatval($discount);
        }

        if ($paymentType == 1 || $paymentType == 2) {

            if ($paymentType == 1) {
                if ($paid == 0) {
                    return response()->json(['errors' => ['error' => 'Paid Amount should be provided.']]);
                }
                if ($paid < $netTotal) {
                    return response()->json(['f' => $paid, 'r' => $netTotal, '$discountType' => $discount, 'errors' => ['error' => 'Paid Amount is lower than net total.']]);
                }
                if ($paid > $netTotal) {
                    return response()->json(['r' => ($paid > $netTotal), 'errors' => ['error' => 'Paid Amount is greater than net total.']]);
                }
            } else if ($paymentType == 1) {
                if ($paid > $netTotal) {
                    return response()->json(['r' => ($paid > $netTotal), 'errors' => ['error' => 'Paid Amount is greater than net total.']]);
                }
            }

        } 

        $countGrnTemp = GRNTemp::where('master_user_idmaster_user', Auth::user()->iduser_master)->get();

        if (count($countGrnTemp) == 0) {
            return response()->json(['errors' => ['error' => 'No items available to save.']]);
        }

        $getPO=PurchaseOrder::find($PoNoId);

        $saveGrn = new MasterGrn();
        $saveGrn->meta_payment = $paymentType;
        $saveGrn->supplier_idsupplier = $getPO->supplier_idsupplier;
        $saveGrn->total = $totalPrice;
        $saveGrn->discount = $discount;
        $saveGrn->date = $systemDate;
        $saveGrn->purchase_order_idpurchase_order = $PoNoId;
        $saveGrn->master_user_idmaster_user=Auth::user()->iduser_master;


        if ($paymentType == 1) {
            $saveGrn->paid = $paid;
            $saveGrn->due = 0;
        } 
       
        $saveGrn->status = '1';
        $saveGrn->save();

        $poCompleted=PurchaseOrder::find($PoNoId);
        $poCompleted->status=2;
        $poCompleted->save();


        
        $grnItemTemps = GRNTemp::where('master_user_idmaster_user', Auth::user()->iduser_master)->get();

        foreach ($grnItemTemps as $grnItemTemp) {

                $saveStockTable = new Stock();
                $saveStockTable->base = 1;
                $saveStockTable->grn_id = $saveGrn->idmaster_grn;
                $saveStockTable->product_idproduct = $grnItemTemp->product_idproduct;
                $saveStockTable->qty_grn = $grnItemTemp->qty;
                $saveStockTable->qty_available = $grnItemTemp->qty;
                $saveStockTable->bp = $grnItemTemp->buying_price;
                $saveStockTable->status = 1;
                $saveStockTable->user_master_iduser_master = Auth::user()->iduser_master;
                $saveStockTable->save();


            $grnItemTemp->delete();
        }

        $savePayment = new Payment();
        $savePayment->base = 1;
        $savePayment->id = $saveGrn->idmaster_grn;
        $savePayment->totalAmount = $netTotal;
       
        if ($paymentType == 1) {
            $savePayment->cash = $paid;
        } 
        $savePayment->status = '1';
        $savePayment->save();

        return response()->json(['success' => 'GRN saved successfully']);
    }

    public function getMoreByGrnID(Request $request)
    {

        $masterId = $request['masterId'];

        $getMasterGrn = MasterGRN::find($masterId);

        $tableData = '';
        $tableData .= "<tr>";
        $tableData .= "<td>" . 'Payment Type' . "</td>";
        $tableData .= "<td>" . MetaPayment::find($getMasterGrn->meta_payment)->name . "</td>";
        $tableData .= "</tr>";
        $tableData .= "<tr>";
        $tableData .= "<td>" . 'Discount' . "</td>";
        $tableData .= "<td>" . number_format($getMasterGrn->discount, 2) . "</td>";
        $tableData .= "</tr>";

        return response()->json(['tableData' => $tableData]);

    }

    public function getByID(Request $request)
    {

        $grnId = $request['grnId'];
        $getStockDetails = Stock::where('grn_id', $grnId)->orderBy('created_at', 'desc')->where('status', 1)->get();
        $tableData = '';

        foreach ($getStockDetails as $getStockDetail) {
            $tableData .= "<tr>";
            $tableData .= "<td>" . $getStockDetail->Product->product_name . "</td>";
            $measurementId=Product::find($getStockDetail->product_idproduct);
           
            $tableData .= "<td >" . number_format($getStockDetail->qty_grn, 2) . "</td>";
            $tableData .= "<td style=\"text-align: right\">" . number_format($getStockDetail->bp, 2) . "</td>";
            $tableData .= "</tr>";
        }
        return response()->json(['tableData' => $tableData, '$uGrnID' => $grnId]);
    }

    public function search(Request $request)
    {


        $supplierSearch = $request['supplierSearch'];
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        $idType = $request['idType'];
        $id = $request['id'];

        $suppliers = Supplier::where('status', 1)->get();

        $query = MasterGRN::query();

        if ($id) {
            $query = $query->where('idmaster_grn', $id);
        }

        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date('Y-m-d', strtotime($request['startDate']));
            $endDate = date('Y-m-d', strtotime($request['endDate']));

            $query = $query->whereBetween('date', [$startDate, $endDate]);
        }
        if (!empty($supplierSearch)) {

            $query = $query->where('supplier_idsupplier', $supplierSearch);
        }

        $grnHistories = $query->where('status', 1)->latest()->paginate(10);

        $grnHistories->appends(array(
            'startDate' => $request['startDate'],
            'endDate' => $request['endDate'],
            'id' => $request['id'],
        ));
        return view('grn.grn-history', ['title' => 'GRN History', 'grnHistories' => $grnHistories, 'suppliers' => $suppliers]);


    }

    public function getPOByDetails(Request $request){
        $POId=$request['POId'];

        $getGrnTemps=GRNTemp::where('master_user_idmaster_user',Auth::user()->iduser_master)->where('purchase_order','!=',$POId)->where('status',1)->get();
        if (count($getGrnTemps)!=null){

            foreach ($getGrnTemps as $getGrnTemp){
                $getGrnTemp->delete();
            }

        }


        $getPurchaseItems=PurchaseOrderReg::where('purchase_order_idpurchase_order',$POId)->where('status',1)->get();


        foreach ($getPurchaseItems as $getPurchaseItem){

            $grnTempSave = new GRNTemp();
            $grnTempSave->buying_price = $getPurchaseItem->bp;
            $grnTempSave->qty = $getPurchaseItem->qty;
            $grnTempSave->product_idproduct = $getPurchaseItem->product_idproduct;
            $grnTempSave->master_user_idmaster_user = Auth::user()->iduser_master;
            $grnTempSave->status = '1';
            $grnTempSave->purchase_order = $POId;
            $grnTempSave->save();


        }

        $getPO=PurchaseOrder::find($POId);
        return response()->json(['po' => $getPO]);
    }

    public function getTempProductId(Request $request){


        $productId=$request['productId'];
        $getTempItem=GRNTemp::find($productId);

        return response()->json($getTempItem);

    }

    public function updateTempProduct(Request $request){

        $uQty=$request['uQty'];
        $uBp=$request['uBp'];
        $hiddenProId=$request['hiddenProId'];

        $rules = \Validator::make($request->all(), [

            'uQty' => 'required||not_in:0',
            'uBp' => 'required||not_in:0',

        ], [

            'uQty.required' => 'Qty should be provided!',
            'uQty.not_in' => 'Qty should be  more than 0!',
            'uBp.required' => 'Buying Price should be provided!',
            'uBp.not_in' => 'Buying Price should be  more than 0!',

        ]);
        if ($rules->fails()) {
            return response()->json(['errors' => $rules->errors()->all()]);
        }


        $updateGrnTemp=GRNTemp::find($hiddenProId);
        $updateGrnTemp->buying_price=$uBp;
        $updateGrnTemp->qty=$uQty;
        $updateGrnTemp->update();

        return \response()->json(['success'=>'Product updated successfully']);
    }
}