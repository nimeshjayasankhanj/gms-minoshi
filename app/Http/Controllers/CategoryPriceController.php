<?php


namespace App\Http\Controllers;

use App\CategoryPrice;
use App\MainCategory;
use Illuminate\Http\Request;

class CategoryPriceController extends Controller
{
        public function categoryPrices(){

            $categories=MainCategory::where('status',1)->get();

            $prices=CategoryPrice::all();
            return view('category_prices.category-prices',['prices'=>$prices,'title'=>'Cloth Prices','categories'=>$categories]);


        }

        public function store(Request $request){

            $validator = \Validator::make($request->all(), [

                'category' => 'required',
                'cPrice' => 'required||not_in:0',
            ], [
                'category.required' => 'Category should be provided!',  
                'cPrice.required' => 'Price should be provided!',  
                'cPrice.not_in' => 'Price should be more than 0!',  
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }

            if(CategoryPrice::where('main_category_idmain_category',$request['category'])->first()){
                
                return response()->json(['availablePrice' =>'Category price already available.']);
            }

            $save=new CategoryPrice();
            $save->price=$request['cPrice'];
            $save->main_category_idmain_category=$request['category'];
            $save->status=1;
            $save->save();

            return response()->json(['success'=>'success']);
        }


        public function edit(Request $request){

            $validator = \Validator::make($request->all(), [

                'uCategory' => 'required',
                'uCPrice' => 'required||not_in:0',
            ], [
                'category.required' => 'Category should be provided!',  
                'uCPrice.required' => 'Price should be provided!',  
                'uCPrice.not_in' => 'Price should be more than 0!',  
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }

            if(CategoryPrice::where('main_category_idmain_category',$request['uCategory'])->where('idcategory_price','!=',$request['hiddenUCatId'])->first()){
                
                return response()->json(['availablePrice' =>'Category price already available.']);
            }

            $edit=CategoryPrice::find($request['hiddenUCatId']);
            $edit->price=$request['uCPrice'];
            $edit->main_category_idmain_category=$request['uCategory'];
            $edit->status=1;
            $edit->save();

            return response()->json(['success'=>'success']);
        }
}