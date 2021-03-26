<?php


namespace App\Http\Controllers;


use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function productsIndex(){

        $productViews=Product::all();
        $categories=Category::where('status',1)->get();
        
        return view('product.products',['title'=>'Products','categories'=>$categories,'productViews'=>$productViews]);

    }

    public function store(Request $request)
    {

        $pName = $request['pName'];
        $category = $request['category'];
        $buyingPrice=$request['buyingPrice'];
        $sellingrice=$request['sellingPrice'];
      

        $validator = \Validator::make($request->all(), [

            'pName' => 'required|max:45',
            'category' => 'required',
            'buyingPrice' => 'required|not_in:0',
            'sellingPrice' => 'required|not_in:0',
        ], [
            'category.required' => 'Category should be provided!',
            'pName.required' => 'Product Name should be provided!',
            'pName.max' => 'Product Name must be less than 45 characters long.',
            'buyingPrice.required' => 'buying Price should be provided!',
            'buyingPrice.not_in' => 'buying Price may not be 0!',
            'sellingPrice.required' => 'Selling Price should be provided!',
            'sellingPrice.not_in' => 'Selling Price may not be 0!',
           
        ]);

        if (Product::where('product_name', strtoupper($pName))->where('category_idcategory', $category)->first()) {
            return response()->json(['errors' => ['error' => 'Product Name already exist.']]);
        }


        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);

        }

        $saveProduct = new Product();
        $saveProduct->category_idcategory = $category;
        $saveProduct->product_name = strtoupper($pName);
        $saveProduct->buying_price = $buyingPrice;
        $saveProduct->selling_price=$sellingrice;
        $saveProduct->user_master_iduser_master = Auth::user()->iduser_master;
        $saveProduct->status = '1';
        $saveProduct->save();

        
        return response()->json(['success' => 'Product saved successfully.']);
    }

    public function getById(Request $request)
    {
        $productId = $request['productId'];

        if($productId!=null){
            $getPrice = Product::find($productId);
            return response()->json($getPrice);
        }

    }

    public function update(Request $request)
    {
        $hiddenUItemId=$request['hiddenUItemId'];
        $uPName = $request['uPName'];
        $uCategory = $request['uCategory'];
        $uDescription = $request['uDescription'];
        $uBuyingPrice=$request['uBuyingPrice'];
        $uSellingPrice=$request['uSellingPrice'];

        $validator = \Validator::make($request->all(), [

            'uCategory' => 'required',
            'uPName' => 'required|max:45',
            'uBuyingPrice' => 'required|not_in:0',
            'uSellingPrice' => 'required|not_in:0',

        ], [
            'uCategory.required' => 'category should be provided!',
            'uPName.required' => 'Product Name should be provided!',
            'uPName.max' => 'Product Name must be less than 45 characters long.',
            'uBuyingPrice.required' => 'Buying Price should be provided!',
            'uBuyingPrice.not_in' => 'Buying Price may not be 0!',
            'uSellingPrice.required' => 'Selling Price should be provided!',
            'uSellingPrice.not_in' => 'Selling Price may not be 0!',
          
        ]);

        if (Product::where('product_name', strtoupper($uPName))->where('idproduct', '!=', $hiddenUItemId)
            ->where('category_idcategory', $uCategory)->first()
        ) {
            return response()->json(['errors' => ['error' => 'Product Name already exist.']]);
        }
        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);

        }

        $updateProduct = Product::find($hiddenUItemId);
        $updateProduct->category_idcategory = $uCategory;
        $updateProduct->product_name = strtoupper($uPName);
        $updateProduct->description = $uDescription;
        $updateProduct->buying_price = $uBuyingPrice;
        $updateProduct->selling_price = $uSellingPrice;
        $updateProduct->update();

       
        return response()->json(['success' => 'Product updated successfully.']);

    }

}
