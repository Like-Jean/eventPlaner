<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;

class AccountController extends Controller
{
    /**
     * Login.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //Check the input data
        $validator = Validator::make($request->all(),[
            'account' => 'required|max:16',
            'password' => 'required|max:20']);
        if($validator->fails()){
            return response()->json(['status'=>404,'message' => 'input error',
            'data'=>null]);
        }

        $account = $request->input('account');
        $password = $request->input('password');

        //Check if the account exist
        try {
            $user = Account::where('account','=',$account)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json(['status'=>403,'message' => 'account not found',
            'data'=>null]);
        }

        //Check if the password is correct
        if ($user->password==$password) {
            return response()->json(['status'=>0,'message' => 'login successfully',
            'data'=>$user->id]);
        }

        else{
            return response()->json(['status'=>402,'message' => 'wrong password',
            'data'=>null]);
        }
    }

    public function index()
    {
        $user = Account::all();
        dd($user);
    }
    /**
     * Register a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //Check if the request has account and password
        $validator = Validator::make($request->all(),[
            'account' => 'required|max:16',
            'password' => 'required|max:20']);

        //If it is lack of account and password
        if($validator->fails()){
            return response()->json(['status'=>404,'message' => 'input error',
            'data'=>null]);
        }

        //Check if the account is existed
        try {
             $exist = Account::where('account', '=', $request->input('account'))->firstOrFail();
         } catch (ModelNotFoundException $e) {

            $account = $request->input('account');
            $password = $request->input('password');

            $name = $request->input('name','default_user');
            $gender = $request->input('gender','unknown');
            $nationality = $request->input('nationality','France');
            $city = $request->input('city','Villejuif');
            $address = $request->input('address','');

            //$hobby = $request->input('hobby','');
            $nickName = $request->input('nickName','');
            $birthday = $request->input('birthday','');

            //store it to the database
            $Account = new Account;
            $Account->account = $account;
            $Account->password = $password;
            $Account->name = $name;
            $Account->nickName = $nickName;
            $Account->gender = $gender;
            $Account->address = $address;
            $Account->nationality = $nationality;
            $Account->city = $city;

            $Account->birthday = $birthday;

            $Account->save();

            return response()->json(['status'=>0,'message' => 'ok',
                'data'=>$Account->id]);
         } 
        
          return response()->json(['status'=>403,'message' => 'account existed',
            'data'=>null]);  
    }

    /**
     * Get the basic info of the account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function personal_info(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            try{
                $account = Account::find($id);
                
            }
            catch(ModelNotFoundException $e)
            {
                return response()->json(['status'=>403,'message' => 'account not found',
                    'data'=>null]);
            }

            $name = $account->name;
            $nickName = $account->nickName;
            $address = $account->address;
            $nationality = $account->nationality;
            $city = $account->city;
            $hobby = $account->hobby;
            $birthday = $account->birthday;
            $gender = $account->gender;

            return response()->json(['status'=>0,'message' => 'ok','data'=>['name'=>$name,'nickName'=>$nickName,
                'gender'=>$gender,'nationality'=>$nationality,'city'=>$city,'address'=>$address,'hobby'=>$hobby,'birthday'=>$birthday]]);
        }
        else{
            return response()->json(['status'=>404,'message' => 'input error',
                    'data'=>null]);
        }
    }

}
