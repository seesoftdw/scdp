<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();//paginate(10);
        if(count($users) > 0){
            return view('user.view-user', compact('users'));
        }else{
            return view('user.view-user');
        }
    }

    public function edit($id)
    {
    }

    public function store(RegisterRequest $request) 
    {
        $user = User::create($request->validated());
        return redirect('/user')->with('success', "User successfully registered.");
    }

    public function get_user_data(Request $request)
    {
        $departmentList = Department::all();
        $user = User::where('id' , $request->user_id)->get();
        return response()->json(['departmentList' => $departmentList, 
                                'user' => $user]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('user.show-user')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($request->password){
            $validate = Validator::make($request->all(), [
                'username' => 'required|unique:users,username,'.$user->id,'id',
                'password' => 'min:8',
                'password_confirmation' => 'same:password'
            ]);
        }
        else{
            $validate = Validator::make($request->all(), [
                'username' => 'required|unique:users,username,'.$user->id,'id',
            ]);
        }
        if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
        }else{
            $user->update($request->all());
            return redirect('user')->with('update', 'User updated!');  
        }
    }

    public function destroy($id)
    {
        $users = User::find($id);
        $users->delete();
        return redirect('user')->with('delete', 'User deleted!'); 
    }
}