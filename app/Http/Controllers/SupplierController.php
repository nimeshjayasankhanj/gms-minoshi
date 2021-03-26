<?php


namespace App\Http\Controllers;


use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{


    public function suppliersIndex(Request $request){

      
        $suppliers = Supplier::orderBy('idSupplier', 'DESC')->get();
       
        return view('supplier.suppliers',['title'=>'Suppliers','suppliers'=>$suppliers]);

    }
    public function store(Request $request)
    {

        $supplierName = $request['supplierName'];
        $contactNo1 = $request['contactNo1'];
        $email = $request['email'];
        $address = $request['address'];
        $taxCode = $request['taxCode'];

        $validator = \Validator::make($request->all(), [

            'supplierName' => 'required|max:45',
            'contactNo1' => 'required|min:9|max:9',
        ], [
            'supplierName.required' => 'supplier Name should be provided!',
            'supplierName.max' => 'supplier Name must be less than 255 characters long.',
            'contactNo1.required' => 'Contact No should be provided!',
            'contactNo1.min' => 'Contact No should be contain 9 number!',
            'contactNo1.max' => 'Contact No should be contain 9 number!',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        $saveSupplier = new Supplier();
        $saveSupplier->company_name = strtoupper($supplierName);
        $saveSupplier->contact_no = $contactNo1;
        $saveSupplier->email = strtolower($email);
        $saveSupplier->address = $address;
        $saveSupplier->user_master_iduser_master = Auth::user()->iduser_master;
        $saveSupplier->status = '1';
        $saveSupplier->save();

     
        return response()->json(['success' => 'Supplier saved successfully']);
    }
   
    public function getById(Request $request){

        $supplierId=$request['supplierId'];
        $getSupplier=Supplier::find($supplierId);

        return response()->json($getSupplier);
    }

    public function update(Request $request)
    {

        $uSupplierName = $request['uSupplierName'];
        $uContactNo1 = $request['uContactNo1'];
        $uEmail = $request['uEmail'];
        $uAddress = $request['uAddress'];
        $uTaxCode = $request['uTaxCode'];
        $hiddenSupplierId=$request['hiddenSupplierId'];

        $validator = \Validator::make($request->all(), [

            'uSupplierName' => 'required|max:45',
            'uContactNo1' => 'required|min:9|max:9',
        ], [
            'uSupplierName.required' => 'supplier Name should be provided!',
            'uSupplierName.max' => 'supplier Name must be less than 255 characters long.',
            'uContactNo1.required' => 'Contact No should be provided!',
            'uContactNo1.min' => 'Contact No should be contain 9 number!',
            'uContactNo1.max' => 'Contact No should be contain 9 number!',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        $updateSupplier =Supplier::find($hiddenSupplierId);
        $updateSupplier->company_name = strtoupper($uSupplierName);
        $updateSupplier->contact_no = $uContactNo1;
        $updateSupplier->email = strtolower($uEmail);
        $updateSupplier->address = $uAddress;
        $updateSupplier->update();

   
        return response()->json(['success' => 'Supplier updated successfully']);
    }

}