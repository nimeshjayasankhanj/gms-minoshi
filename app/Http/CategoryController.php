<?php


namespace App\Http\Controllers;


use App\Category;
use App\Customer;
use App\Measurement;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function categoriesIndex(Request $request){



        $paginate = 10;
        $keyword = $request['search'];
        $column = '';
        $categories = Category::orderBy('created_at', 'desc')
            ->Where(function ($query) use ($column, $keyword) {
                $query->where('catName' . $column . '', 'LIKE', "%$keyword%")->where('master_company', Auth::user()->master_company);
            })
            ->orderBy('idcategory', 'DESC')->paginate($paginate);
        $categories->appends(array('search' => $request['search'],));


        return view('category.categories',['title'=>'categories','categories'=>$categories]);
    }

    public function store(Request $request){

        $category=$request['category'];

        $validator = \Validator::make($request->all(), [

            'category' => 'required|max:20',
        ], [
            'category.required' => 'category should be provided!',
            'category.max' => 'category must be less than 20 characters long.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $categoryExist = Category::where('catName', strtoupper($category))->where('master_company',Auth::user()->master_company)->first();

        if($categoryExist!=null){

            return \response()->json(['errors' => ['a' => 'Category already exist.']]);
        }

        $save=new Category();
        $save->catName=strtoupper($category);
        $save->status='1';
        $save->master_user_idmaster_user=Auth::user()->idmaster_user;
        $save->master_company=Auth::user()->master_company;
        $save->save();

        $tableData='';
        $categories=Category::where('master_company',Auth::user()->master_company)->orderBy('created_at', 'desc')->paginate(10);

        if (count($categories)!=null){
            foreach ($categories as $category) {
                $tableData .= "<tr>";
                $tableData .= "<td>" . $category->catName . "</td>";
                $tableData .= "<td>" . $category->User->first_name . "</td>";
                $tableData .= "<td>" . $category->created_at . "</td>";


                if($category->fixed==1){
                    $tableData .= "<td  style='color: red'>" . 'Fixed' . "</td>";
                }else{
                    if ($category->status == 1) {

                        $tableData .= "<td>";
                        $tableData .= "<input type='checkbox' class='btn  btn-sm btn-danger' onchange=adMethod('$category->idcategory','category') id='c" . $category->idcategory . "' checked switch='none'/>";
                        $tableData .= "<label for='c" . $category->idcategory . "' data-on-label='On' data-off-label='Off'></label>";
                        $tableData .= "</td>";
                    } else {
                        $tableData .= "<td>";
                        $tableData .= "<input type='checkbox' class='btn  btn-sm btn-danger' onchange=adMethod('$category->idcategory','category') id='c" . $category->idcategory . "'  switch='none'/>";
                        $tableData .= "<label for='c" . $category->idcategory . "' data-on-label='On' data-off-label='Off'></label>";
                        $tableData .= "</td>";
                    }
                }

                  $tableData .= "<td>";
                  $tableData .= " <p>";
                  $tableData .= "<button type='button' class='btn btn-sm btn-warning  waves-effect waves-light'
              data-toggle='modal' data-id='$category->idcategory' id='uCategoryID' data-target='#updateCategoryModal'>";
                  $tableData .= "<i class='fa fa-edit'></i>";
                  $tableData .= "</button>";
                  $tableData .= " </p>";
                  $tableData .= " </td>";


                $tableData .= "</tr>";
            }
        }

       return \response()->json(['success'=>'Category saved successfully','tableData'=>$tableData]);
    }

    public function getById(Request $request){

        $categoryId=$request['categoryId'];

        $category=Category::find($categoryId);

        return \response()->json($category);
    }

    public function update(Request $request){

        $uCategory=$request['uCategory'];
        $hiddenCatId=$request['hiddenCatId'];
        $validator = \Validator::make($request->all(), [

            'uCategory' => 'required|max:20',
        ], [
            'uCategory.required' => 'category should be provided!',
            'uCategory.max' => 'category must be less than 20 characters long.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $categoryExist = Category::where('catName', strtoupper($uCategory))->where('idcategory','!=',$hiddenCatId)->where('master_company',Auth::user()->master_company)->first();

        if($categoryExist!=null){

            return \response()->json(['errors' => ['a' => 'Category already exist.']]);
        }

        $update=Category::find($hiddenCatId);
        $update->catName=strtoupper($uCategory);
        $update->update();

        $tableData='';
        $categories=Category::where('master_company',Auth::user()->master_company)->orderBy('created_at', 'desc')->paginate(10);

        if (count($categories)!=null){
            foreach ($categories as $category) {
                $tableData .= "<tr>";
                $tableData .= "<td>" . $category->catName . "</td>";
                $tableData .= "<td>" . $category->User->first_name . "</td>";
                $tableData .= "<td>" . $category->created_at . "</td>";


                    if ($category->status == 1) {

                        $tableData .= "<td>";
                        $tableData .= "<input type='checkbox' class='btn  btn-sm btn-danger' onchange=adMethod('$category->idcategory','category') id='c" . $category->idcategory . "' checked switch='none'/>";
                        $tableData .= "<label for='c" . $category->idcategory . "' data-on-label='On' data-off-label='Off'></label>";
                        $tableData .= "</td>";
                    } else {
                        $tableData .= "<td>";
                        $tableData .= "<input type='checkbox' class='btn  btn-sm btn-danger' onchange=adMethod('$category->idcategory','category') id='c" . $category->idcategory . "'  switch='none'/>";
                        $tableData .= "<label for='c" . $category->idcategory . "' data-on-label='On' data-off-label='Off'></label>";
                        $tableData .= "</td>";
                    }



                    $tableData .= "<td>";
                    $tableData .= " <p>";
                    $tableData .= "<button type='button' class='btn btn-sm btn-warning  waves-effect waves-light'
              data-toggle='modal' data-id='$category->idcategory' id='uCategoryID' data-target='#updateCategoryModal'>";
                    $tableData .= "<i class='fa fa-edit'></i>";
                    $tableData .= "</button>";
                    $tableData .= " </p>";
                    $tableData .= " </td>";


                $tableData .= "</tr>";
            }
        }

        return \response()->json(['success'=>'Category updated successfully','tableData'=>$tableData]);
    }

}