<?php


namespace App\Http\Controllers;

use App\BookingReg;
use App\CategoryPrice;
use App\Mail\PendingOrder;
use App\MainCategory;
use App\MasterBooking;
use App\Product;
use App\Stock;
use App\TempBooking;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomerBookingController extends Controller
{
    public function makeABooking()
    {

        $products = Product::where('status', 1)->get();

        return view('booking.make-a-booking', ['title' => 'Make an Invoice', 'products' => $products]);
    }

    public function completedCusWorksIndex()
    {

        $completedBooking = MasterBooking::where('status', 2)->where('user_master_iduser_master', Auth::user()->iduser_master)->get();


        return view('booking-history.completed-cus-works', ['title' => 'Completed Works', 'completedBooking' => $completedBooking]);
    }


    public function pendingCusWorks()
    {

        $pendingBooking = MasterBooking::where('status', 0)->where('user_master_iduser_master', Auth::user()->iduser_master)->get();

        return view('booking-history.pending-cus-works', ['title' => 'Pending Orders', 'pendingBooking' => $pendingBooking]);
    }

    public function getProductPrice(Request $request)
    {

        $productID = $request['productID'];

        $getPrice = Product::where('idproduct', $productID)->first();

        return response()->json($getPrice);
    }

    public function getAvailableQty(Request $request)
    {

        $itemId = $request['itemId'];

        $availableQty = Stock::where('status', 1)->where('product_idproduct', $itemId)->get();

        $total = 0;
        foreach ($availableQty as $available) {
            $total += $available->qty_available;
        }

        $tempQty = 0;

        $getTempQty = TempBooking::where('user_master_iduser_master', Auth::user()->iduser_master)->where('product_idproduct', $itemId)->get();

        foreach ($getTempQty as $getTempQty) {
            $tempQty += $getTempQty->qty;
        }

        return $total - $tempQty;
    }

    public function saveTempProduct(Request $request)
    {

        $validator = \Validator::make($request->all(), [

            'product' => 'required',
            'qty' => 'required||not_in:0',
        ], [
            'product.required' => 'Product should be provided!',
            'qty.required' => 'Qty should be provided!',
            'qty.not_in' => 'Qty should be more than 0!',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if (TempBooking::where('product_idproduct', $request['product'])->where('user_master_iduser_master', Auth::user()->iduser_master)->exists()) {
            $updateQty = TempBooking::where('product_idproduct', $request['product'])->where('user_master_iduser_master', Auth::user()->iduser_master)->first();

            $updateQty->qty += $request['qty'];
            $updateQty->save();
        } else {
            $save = new TempBooking();
            $save->qty = $request['qty'];
            $save->status = 1;
            $save->product_idproduct = $request['product'];
            $save->user_master_iduser_master = Auth::user()->iduser_master;
            $save->save();
        }



        return response()->json(['success' => 'Product added successfully.']);
    }

    public function tableData()
    {

        $tableData = '';
        $temFIles = TempBooking::where('status', 1)->where('user_master_iduser_master', Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
        $tableData2 = "";
        $total = 0;
        if (count($temFIles) != null) {

            foreach ($temFIles as $temFIle) {

                $tableData .= "<tr>";

                $tableData .= "<td>" . $temFIle->Product->product_name . "</td>";
                $tableData .= "<td>" . $temFIle->qty . "</td>";
                $price = Product::find($temFIle->product_idproduct);
                $tableData .= "<td style='text-align: right'>" . number_format($temFIle->qty * $price->selling_price, 2) . "</td>";
                $total += $temFIle->qty * $price->selling_price;

                $tableData .= "<td>";
                $tableData .= " <p>";
                $tableData .= "<button type='button' class='btn btn-sm btn-danger  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' id='deleteId'>";
                $tableData .= "<i class='fa fa-trash'></i>";
                $tableData .= "</button>";
                $tableData .= " </p>";
                $tableData .= " </td>";

                $tableData .= "<td>";
                $tableData .= " <p>";
                $tableData .= "<button type='button' class='btn btn-sm btn-warning  waves-effect waves-light'
                data-toggle='modal' data-id='$temFIle->idtemp_booking' data-product='$temFIle->product_idproduct' data-qty='$temFIle->qty'  id='uTempID' data-target='#updateCategoryModal'>";
                $tableData .= "<i class='fa fa-edit'></i>";
                $tableData .= "</button>";
                $tableData .= " </p>";
                $tableData .= " </td>";

                $tableData2 .= "<div class='col-lg-4'>";
                $tableData2 .= "<p>" . $temFIle->Product->product_name . "</p>";
                $tableData2 .= "</div>";
                $tableData2 .= "<div class='col-lg-4'>";
                $tableData2 .= "<p>" . $temFIle->qty . ' Qty' . "</p>";
                $tableData2 .= "</div>";
                $tableData2 .= "<div class='col-lg-4'>";
                $tableData2 .= "<p style='text-align: right'>" . number_format($temFIle->qty * $price->selling_price, 2) . "</p>";
                $tableData2 .= "</div>";
            }
        } else {
            $tableData .= "<tr>";
            $tableData .= "<td colspan='6' style='text-align: center;font-weight: bold'>" . 'Sorry No Results Found.' . "</td>";
            $tableData .= "</tr>";
        }

        if ($total == 0) {
            $tableData2 .= "<div class='col-lg-12'>";
            $tableData2 .= "<b style='text-align: center;font-weight: bold;'>" . 'Sorry No Results Found' . "</b>";
            $tableData2 .= "</div>";
        } else {
            $tableData2 .= "<div class='col-lg-4'>";
            $tableData2 .= "<b>" . 'Total (Rs)' . "</b>";
            $tableData2 .= "</div>";
            $tableData2 .= "<div class='col-lg-4'>";

            $tableData2 .= "</div>";
            $tableData2 .= "<div class='col-lg-4'>";
            $tableData2 .= "<p style='text-align: right;font-weight: bold;'>" . number_format($total, 2) . "</p>";
            $tableData2 .= "</div>";
        }


        return response()->json(['total' => $total, 'tableData' => $tableData, 'tableData2' => $tableData2, 'total' => $total]);
    }

    public function deleteTempBooking(Request $request)
    {

        $tempId = $request['tempId'];

        $delete = TempBooking::find($tempId);
        if ($delete != null) {
            $delete->delete();
        }


        $tableData = '';
        $temFIles = TempBooking::where('status', 1)->where('user_master_iduser_master', Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
        $tableData2 = "";
        $total = 0;



        return response()->json(['total' => $total, 'success' => 'Product deleted successfully.']);
    }



    public function editTempBooking(Request $request)
    {

        $validator = \Validator::make($request->all(), [

            'uProduct' => 'required',
            'uQty' => 'required||not_in:0',
        ], [
            'uProduct.required' => 'Product should be provided!',
            'uQty.required' => 'Qty should be provided!',
            'uQty.not_in' => 'Qty should be more than 0!',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


        if (TempBooking::where('product_idproduct', $request['uProduct'])->where('user_master_iduser_master', Auth::user()->iduser_master)->exists()) {
            $updateQty = TempBooking::find($request['hiddenTempId']);
            $updateQty->qty = $request['uQty'];
            $updateQty->save();
        }



        return response()->json(['success' => 'Product edit successfully.']);
    }

    public function saveBooking(Request $request)
    {


        $temFIles = TempBooking::where('status', 1)->where('user_master_iduser_master', Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();
        $total = 0;
        $systemDate = Carbon::now()->format('y/m/d');

        foreach ($temFIles as $temFIle) {
            $price = Product::find($temFIle->product_idproduct);
            $total += $temFIle->qty * $price->selling_price;
        }


        $save = new MasterBooking();
        $save->total = $total;
        $save->status = 0;
        $save->date=$systemDate;
        $save->user_master_iduser_master = Auth::user()->iduser_master;
        $save->save();

        $tempBooking = TempBooking::where('status', 1)->where('user_master_iduser_master', Auth::user()->iduser_master)->orderBy('created_at', 'desc')->get();

        foreach ($tempBooking as $temp) {

            $stockQty = Stock::where('status', 1)
                ->where('qty_available', '>', 0)
                ->where('product_idproduct', $temp->product_idproduct)->get();


            foreach ($stockQty as $stock) {
                if ($stock->qty_available == 0) {
                    $stock->status = '0';
                    $stock->update();
                   
                    break;
                } else if ($stock->qty_available > $temp->qty) {
                    $stock->qty_available -= $temp->qty;
                    $stock->save();
                  
                    break;
                } else if ($stock->qty_available == $temp->qty) {
                    $stock->qty_available -= $temp->qty;
                    $stock->status = 0;
                    $stock->save();
                  
                    break;
                }
            }



            $saveBooking = new BookingReg();
            $saveBooking->status = 1;
            $saveBooking->qty = $temp->qty;
            $saveBooking->product_idproduct = $temp->product_idproduct;
            $saveBooking->master_booking_idmaster_booking = $save->idmaster_booking;
            $saveBooking->save();

            $temp->delete();
        }



        return response()->json(['success' => 'Booking saved successfully.', 'total' => $total]);
    }
}
