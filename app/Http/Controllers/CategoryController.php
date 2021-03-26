<?php


namespace App\Http\Controllers;

use App\MainCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
        public function categories(){

            $mainCategories=MainCategory::all();

            return view('categories.categories',['title'=>'Cloths','mainCategories'=>$mainCategories]);
        }

        public function save(Request $request){

            $validator = \Validator::make($request->all(), [

                'category' => 'required|max:45',
                 
            ], [
                'category.required' => 'Category should be provided!',  
                'category.max' => 'Category must be less than 45 characters.',
              
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }

            $available=MainCategory::where('main_category_name',$request['category'])->exists();
            if($available!=null){
                return response()->json(['errors'=>'Category name already exist']);
            }else{
                $save=new MainCategory();
                $save->main_category_name=strtoupper($request['category']);
                $save->status=1;
                $save->save();

                return response()->json(['success' => 'Category saved successfully.']);
            }
        }

    

        public function edit(Request $request){

            $validator = \Validator::make($request->all(), [

                'uCategory' => 'required|max:45',
                 
            ], [
                'uCategory.required' => 'Category should be provided!',  
                'uCategory.max' => 'Category must be less than 45 characters.',
              
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }

            $available=MainCategory::where('main_category_name',$request['uCategory'])->where('idmain_category','!=',$request['hiddenCatId'])->exists();
            if($available!=null){
                return response()->json(['errors'=>'Category name already exist']);
            }else{
                $edit=MainCategory::find($request['hiddenCatId']);
                $edit->main_category_name=strtoupper($request['uCategory']);
                $edit->save();

                return response()->json(['success' => 'Category edit successfully.']);
            }

        }

    public function changeStatus(Request $request){


        $table = MainCategory::find($request['id']);
        if ($table->status == 1) {
            $table->status = 0;
        } else {
            $table->status = 1;
        }
        $table->update();
    }

}