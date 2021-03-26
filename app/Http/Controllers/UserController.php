<?php


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function addemployeeIndex(){

        return view('employee.add-employee',['title'=>"Add Driver"]);
    }
    public function viewCustomerIndex(){

        $customers=User::where('status',1)->where('user_role_iduser_role',2)->get();

        return view('customer.view-customers',['title'=>"View Customer",'customers'=>$customers]);
    }

    public function viewUsersIndex(){

        $customers=User::find(Auth::user()->iduser_master);

        return view('customer.view-customers',['title'=>"View Customer",'customer'=>$customers]);
    }
    

    public function saveDriver(Request $request){

        $validator = \Validator::make($request->all(), [

            'fName' => 'required|max:115',
            'lName' => 'required|max:115',
           
            'contactNo' => 'required|max:10|min:10',
            'username' => 'required|email',
            'password' => 'required|min:9',
            
        ], [
            'fName.required' => 'First Name should be provided!',
            
            'fName.max' => 'Last Name must be less than 115 characters.',
            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',
            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.max' => 'Contact No must be include 10 number.',
            'contactNo.min' => 'Contact No must be include 10 number.',
            'username.required' => 'User name should be provided!',
            'username.email' => 'User name should be valid email address!',
            'password.max' => 'Password must be include 9 number.',
            'password.required' => 'Password should be provided.',
            
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);

        }

        $save=new User();
    
        $save->first_name=strtoupper($request['fName']);
        $save->last_name=strtoupper($request['lName']);
        $save->contact_no=$request['contactNo'];
        $save->email=strtolower($request['email']);
        $save->username=$request['username'];
        $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['password'],"Nova6566", 256));
        $save->password=$advanceEncryption->encrypt();
        $save->status=1;
        $save->user_role_iduser_role=3;
        $save->save();

      

        return response()->json(['success' => 'Driver saved successfully.']);
        

    }

        public function save(Request $request){

            $validator = \Validator::make($request->all(), [

                'fName' => 'required|max:115',
                'lName' => 'required|max:115',
               
                'contactNo' => 'required|max:10|min:10',
                'username' => 'required|email',
                'password' => 'required|min:9',
                
            ], [
                'fName.required' => 'First Name should be provided!',
                
                'fName.max' => 'Last Name must be less than 115 characters.',
                'lName.required' => 'Last Name should be provided!',
                'lName.max' => 'Last Name must be less than 115 characters.',
                'contactNo.required' => 'Contact No should be provided!',
                'contactNo.max' => 'Contact No must be include 10 number.',
                'contactNo.min' => 'Contact No must be include 10 number.',
                'username.required' => 'User name should be provided!',
                'username.email' => 'User name should be valid email address!',
                'password.max' => 'Password must be include 9 number.',
                'password.required' => 'Password should be provided.',
                
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }
    
            $save=new User();
        
            $save->first_name=strtoupper($request['fName']);
            $save->last_name=strtoupper($request['lName']);
            $save->contact_no=$request['contactNo'];
            $save->email=strtolower($request['email']);
            $save->username=$request['username'];
            $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['password'],"Nova6566", 256));
            $save->password=$advanceEncryption->encrypt();
            $save->status=1;
            $save->user_role_iduser_role=2;
            $save->save();
    
          
    
            return response()->json(['success' => 'Customer saved successfully.']);

        }


        public function updatePassword(Request $request)
        {
            $update_pass2 = $request['update_pass2'];
            $hiddenPID = $request['hiddenPID'];
            $compass = $request['compass'];
    
            $validator = \Validator::make($request->all(), [
                'update_pass2' => 'required',
                'compass' => 'required',
    
            ], [
                'update_pass2.required' => 'Password should be provided!',
                'compass.required' => 'Conform Password should be provided!',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }
            if ($compass != $update_pass2) {
                return response()->json(['errors' => ['error'=>'Password not match.']]);
            }
    
            $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['password'],"Nova6566", 256));
            
            $pass = User::find(intval($hiddenPID));
            $pass->password = $advanceEncryption->encrypt();
            $pass->save();
    
            return response()->json(['success' => 'Password updated successfully ']);
    
        }
    
        public function getUserById(Request $request){

            $userId=$request['userId'];

            $getUser=User::find($userId);

            return \response()->json($getUser);
        }


        public function updateUser(Request $request){

            $validator = \Validator::make($request->all(), [

                'fName' => 'required|max:115',
                'lName' => 'required|max:115',
                'email' => 'required',
                'contactNo' => 'required|max:10|min:10',
                'nicNo' => 'required',
              
                
            ], [
                'fName.required' => 'First Name should be provided!',
                'email.required' => 'Email should be provided!',
                'fName.max' => 'Last Name must be less than 115 characters.',
                'lName.required' => 'Last Name should be provided!',
                'lName.max' => 'Last Name must be less than 115 characters.',
                'contactNo.required' => 'Contact No should be provided!',
                'contactNo.max' => 'Contact No must be include 10 number.',
                'contactNo.min' => 'Contact No must be include 10 number.',
                'nicNo.required' => 'NIC should be provided!',
               
                
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' =>$validator->errors()]);
    
            }
    
            $update=User::find($request['hiddenUID']);
            $update->first_name=strtoupper($request['fName']);
            $update->last_name=strtoupper($request['lName']);
            $update->contact_no=$request['contactNo'];
            $update->email=strtolower($request['email']);
            $update->nic=$request['nicNo'];
            $update->save();
    
          
    
            return response()->json(['success' => 'Customer updated successfully.']);
        }

}