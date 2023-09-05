<?php


namespace App\Http\Services;


use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function showAllUser(){
        $users = User::all();
        foreach ($users as $user){
            $data [] = $this->userDetail($user->id);
        }
        return $data;
    }

    public function userDetail($id){
        $user = User::where('id',$id)->select('id','name','phone','address','email','is_admin','created_at','updated_at')->first();
        return json_decode(json_encode($user),true);
    }

    public function createUserAdmin($request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->is_admin = true; // Set quyền admin
            $user->save();

            return 'User admin created successfully';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateUser($request, $id){
        $request->validate(['phone'=>'numeric']);

        $user = User::find($id);
        $user->name = $request->input('name');;
        $user->phone = $request->input('phone');;
        $user->address = $request->input('address');
        $user->save();
        return 'Updated Successfully';
    }

    public function deleteUser($user_id){
        $user = User::find($user_id);
        if ($user->id == 0)     //Delete Cart if not Admin
            $this->deleteCart($user_id);
        $user->delete();
        return 'Delete User Successfully';
    }
    public function deleteCart($user_id){
        $cart = Cart::where('user_id',$user_id)->first();
        $cart->delete();
    }

}
