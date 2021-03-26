<?php


namespace App\Http\Controllers;


use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{






    public function suppliersIndex(Request $request){

        $paginate = 10;
        $keyword = $request['search'];
        $column = '';
        $suppliers = Supplier::orderBy('created_at', 'desc')
            ->Where(function ($query) use ($column, $keyword) {
                $query->where('company_name' . $column . '', 'LIKE', "%$keyword%")->where('master_company', Auth::user()->master_company);
            })->orWhere(function ($query) use ($column, $keyword) {
                $query->where('contactNo1' . $column . '', 'LIKE', "%$keyword%")->where('master_company', Auth::user()->master_company);
            })->orWhere(function ($query) use ($column, $keyword) {
                $query->where('email' . $column . '', 'LIKE', "%$keyword%")->where('master_company', Auth::user()->master_company);
            })->orWhere(function ($query) use ($column, $keyword) {
                $query->where('taxCode' . $column . '', 'LIKE', "%$keyword%")->where('master_company', Auth::user()->master_company);
            })->orWhere(function ($query) use ($column, $keyword) {
                $query->where('address' . $column . '', 'LIKE', "%$keyword%")->where('master_company', Auth::user()->master_company);
            })

            ->orderBy('idSupplier', 'DESC')->paginate($paginate);
        $suppliers->appends(array('search' => $request['search'],));




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
        $saveSupplier->master_company = Auth::user()->master_company;
        $saveSupplier->company_name = strtoupper($supplierName);
        $saveSupplier->contactNo1 = $contactNo1;
        $saveSupplier->email = strtolower($email);
        $saveSupplier->address = $address;
        $saveSupplier->taxCode = $taxCode;
        $saveSupplier->master_user_idmaster_user = Auth::user()->idmaster_user;
        $saveSupplier->status = '1';
        $saveSupplier->save();

        $suppliers = Supplier::where('master_company', Auth::user()->master_company)->orderBy('created_at', 'desc')->paginate(10);
        $tableData = '';
        foreach ($suppliers as $supplier) {
            $tableData .= "<tr>";
            $tableData .= "<td>" . $supplier->company_name . "</td>";
            $tableData .= "<td>" . $supplier->contactNo1 . "</td>";
            $tableData .= "<td>" . $supplier->email . "</td>";
            $tableData .= "<td>" . $supplier->User->first_name . "</td>";
            $tableData .= "<td>" . $supplier->created_at . "</td>";
            if ($supplier->status == 1) {

                $tableData .= "<td>";
                $tableData .= "<input type='checkbox' class='btn  btn-sm btn-danger' onchange=adMethod('$supplier->idsupplier','Supplier') id='c" . $supplier->idsupplier . "' checked switch='none'/>";
                $tableData .= "<label for='c" . $supplier->idsupplier . "' data-on-label='On' data-off-label='Off'></label>";
                $tableData .= "</td>";
            } else {
                $tableData .= "<td>";
                $tableData .= "<input type='checkbox' class='btn  btn-sm btn-danger' onchange=adMethod('$supplier->idsupplier','Supplier') id='c" . $supplier->idsupplier . "'  switch='none'/>";
                $tableData .= "<label for='c" . $supplier->idsupplier . "' data-on-label='On' data-off-label='Off'></label>";
                $tableData .= "</td>";
            }
            $tableData .= "<td>";
            $tableData .= "<div class='dropdown'>";
            $tableData .= "<button class='btn btn-outline-success btn-sm dropdown-toggle'  type='button' id='dropdownMenuButton'  data-toggle='dropdown' aria-haspopup='true'  aria-expanded='false'>Option  </button>";
            $tableData .= " <div class='dropdown-menu'   aria-labelledby='dropdownMenuButton'>";
            $tableData .= " <a class='dropdown-item' href = '#'  data-toggle= 'modal' data-id ='$supplier->idsupplier'  id = 'updateSupplierModal'   data-target = '#updateSupplier' >Edit</a >";

            $tableData .= "<a class='dropdown-item' href = '#' data-toggle = 'modal' data-id = '$supplier->idsupplier'  id = 'viewSupplierModal' data-target = '#viewSupplier' >View</a >";

            $tableData .= "  </div >";
            $tableData .= " </td>";
            $tableData .= "</tr>";
        }
        return response()->json(['success' => 'Supplier saved successfully','tableData'=>$tableData]);
    }
    public function viewTableData(Request $request)
    {

        $supplierId = $request['supplierId'];
        $getSupplier = Supplier::find($supplierId);


        $tableData = "";
        $tableData .= "<tr><td width='40%'>Supplier Name</td><td width='60%'> : ".$getSupplier->company_name."</td></tr>";
        $tableData .= "<tr><td width='40%'>Contact No</td><td width='60%'> : <a href='tel:$getSupplier->contactNo1'>".$getSupplier->contactNo1."</a></td></tr>";
        $tableData .= "<tr><td width='40%'>Email</td><td width='60%'> : <a href='mailto:$getSupplier->email'>".$getSupplier->email."</a></td></tr>";

        $tableData .= "<tr><td width='40%'>Address</td><td width='60%'> : ".$getSupplier->address."</td></tr>";
        $tableData .= "<tr><td width='40%'>Tax Code</td><td width='60%'> :".$getSupplier->taxCode."</td></tr>";
        $tableData .= "<tr><td width='40%'>Created/Updated By</td><td width='60%'>: ".$getSupplier->User->first_name."</td></tr>";
        $tableData .= "<tr><td width='40%'>Created At</td><td width='60%'> : ".$getSupplier->created_at."</td></tr>";

        return response()->json(['tableData'=>$tableData]);
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
        $updateSupplier->contactNo1 = $uContactNo1;
        $updateSupplier->email = strtolower($uEmail);
        $updateSupplier->address = $uAddress;
        $updateSupplier->taxCode = $uTaxCode;
        $updateSupplier->update();

        $suppliers = Supplier::where('master_company', Auth::user()->master_company)->orderBy('created_at', 'desc')->paginate(10);
        $tableData = '';
        foreach ($suppliers as $supplier) {
            $tableData .= "<tr>";
            $tableData .= "<td>" . $supplier->company_name . "</td>";
            $tableData .= "<td>" . $supplier->contactNo1 . "</td>";
            $tableData .= "<td>" . $supplier->email . "</td>";
            $tableData .= "<td>" . $supplier->User->first_name . "</td>";
            $tableData .= "<td>" . $supplier->created_at . "</td>";
            if ($supplier->status == 1) {

                $tableData .= "<td>";
                $tableData .= "<input type='checkbox' class='btn  btn-sm btn-danger' onchange=adMethod('$supplier->idsupplier','Supplier') id='c" . $supplier->idsupplier . "' checked switch='none'/>";
                $tableData .= "<label for='c" . $supplier->idsupplier . "' data-on-label='On' data-off-label='Off'></label>";
                $tableData .= "</td>";
            } else {
                $tableData .= "<td>";
                $tableData .= "<input type='checkbox' class='btn  btn-sm btn-danger' onchange=adMethod('$supplier->idsupplier','Supplier') id='c" . $supplier->idsupplier . "'  switch='none'/>";
                $tableData .= "<label for='c" . $supplier->idsupplier . "' data-on-label='On' data-off-label='Off'></label>";
                $tableData .= "</td>";
            }
            $tableData .= "<td>";
            $tableData .= "<div class='dropdown'>";
            $tableData .= "<button class='btn btn-outline-success btn-sm dropdown-toggle'  type='button' id='dropdownMenuButton'  data-toggle='dropdown' aria-haspopup='true'  aria-expanded='false'>Option  </button>";
            $tableData .= " <div class='dropdown-menu'   aria-labelledby='dropdownMenuButton'>";
            $tableData .= " <a class='dropdown-item' href = '#'  data-toggle= 'modal' data-id ='$supplier->idsupplier'  id = 'updateSupplierModal'   data-target = '#updateSupplier' >Edit</a >";

            $tableData .= "<a class='dropdown-item' href = '#' data-toggle = 'modal' data-id = '$supplier->idsupplier'  id = 'viewSupplierModal' data-target = '#viewSupplier' >View</a >";

            $tableData .= "  </div >";
            $tableData .= " </td>";
            $tableData .= "</tr>";
        }
        return response()->json(['success' => 'Supplier updated successfully','tableData'=>$tableData]);
    }

}