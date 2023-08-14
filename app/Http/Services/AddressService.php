<?php


namespace App\Http\Services;


use App\Models\Address;

class AddressService
{
    public function showAllAddress(){
        $user_id = auth()->id();
        $data = Address::where('user_id',$user_id)->get();
        $addresses = json_decode(json_encode($data),true);
        return $addresses;
    }
    public function addNewAddress($request){
        $new_address = new Address();
        $new_address->user_id = auth()->id();
        $new_address->receiver_name = $request->receiver_name;
        $new_address->contact_number = $request->contact_number;
        $new_address->specific_address = $request->specific_address;
        $new_address->save();


    }

    public function updateAddress($request,$id){
        $address = Address::where('id',$id)->first();
        $address->user_id = auth()->id();
        $address->receiver_name = $request->receiver_name;
        $address->contact_number = $request->contact_number;
        $address->specific_address = $request->specific_address;
        $address->save();
    }

}
