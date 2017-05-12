<?php

namespace App\Http\Controllers;

use App\country;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    public function show(){
        $users = User::all();
        $countries = country::all();
        return view('adminPanel')->with(compact('users', 'countries'));
    }

    public function setUnsetAdmin($id, Request $r){
        $user = User::find($id);
        if($r->set == 1){
            $user->is_admin = 1;
            $user->save();
        } elseif($r->set == 0) {
            $user->is_admin = 0;
            $user->save();
        }
        return redirect('/adminPanel');
    }


    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return redirect('/adminPanel');
    }


    public function register(Request $r){
        $credentials = ['name'=>$r->name, 'email'=>$r->email, 'password'=>$r->password];
        $credentials['password'] = Hash::make($credentials['password']);
        try {
            $user = User::create($credentials);
        } catch (Exception $e) {
            return Response::json(['error' => 'User already exists.'], \Illuminate\Http\Response::HTTP_CONFLICT);
        }

        return 'ok';
    }
}
