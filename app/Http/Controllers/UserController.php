<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use App\Http\Controllers\DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //index
    public function index(Request $request){

        $users = DB::table('users')
        ->when($request->input('name'), function ($query, $name) {
          return  $query->where('name', 'like', '%' . $name . '%');

                    // ->orWhere('email', 'like', '%' . $email . '%')
                    // ->orWhere('phone', 'like', '%' . $phone . '%');




                    // ->orWhere('email', 'like', "%{$request->keyword}%")
                    // ->orWhere('phone', 'like', "%{$request->keyword}%");

        })

        //get user all
        // $users = \App\Models\User::all();

        //get user with pagination

        ->paginate(5);
        return view('pages.user.index', compact('users'));
    }
    //create
     public function create(){
        return view('pages.user.create');
    }
     public function store(Request $request){
        $data = $request->all();
        $data ['password'] = Hash::make($request->input('password'));
        User::create($data);
        return redirect()->route('user.index');
    }
     public function show($id){
        return view('pages.dashboard');
    }
    //edit
     public function edit($id){
        $user = User::findOrfail($id);
        return view('pages.user.edit', compact('user'));
    }

    //update
     public function update(Request $request, $id){
        $data = $request->all();


        $user = User::findOrfail($id);
        //check if pw is not empty

        if($request->input('password')){
            $data['password'] = Hash::make($request->input('password'));
        } else{
            $data['password'] = $user->password;
        }
        $user->update($data);


        return redirect()->route('user.index');
    }
    //delete
     public function destroy($id){
        $user = User::findOrfail($id);
        $user->delete();


        return redirect()->route('user.index');
    }
}
