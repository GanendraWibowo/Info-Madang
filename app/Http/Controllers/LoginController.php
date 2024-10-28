<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //show login page pelanggan
    public function index(){
        return view('login');
    }

    //authenticate user
    public function authenticate(Request $request){
        $validator =  Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()){

        }else {
            return redirect()->route('account.login')
            ->withInput()
            ->withErrors($validator);
        }
    }
}
