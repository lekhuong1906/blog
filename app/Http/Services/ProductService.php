<?php

namespace App\Http\Services;

use App\Models\ImageProduct;
use App\Models\Product;


class ProductService extends ProcessService
{

    public function createProduct($data)
    {
        $product = new Product();
        $product->fill($data->all());
        $product->save();

        return $this->formatJson(Product::all());
    }


    public function productDetail($id){
        $product = Product::find($id);
        $data = json_decode(json_encode($product),true);
        $imageUrls = $this->getImage($product->id);

        $data['product_image'] = $imageUrls;

        return $data;
    }

    public function getAllProduct(){
        $data['backPack']=$this->getBackPack();
        $data['wallet']=$this->getWallet();
        $data['tote']=$this->getTote();
        $data['crossbody']=$this->getCrossbody();
        return ($data);
    }

    public function getBackPack(){
        $data=[];
        $backPacks = Product::where('product_type',1)->get();
        foreach ($backPacks as $backPack){
            $image = $this->getImage($backPack->id);
            $arr = json_decode(json_encode($backPack),true);
            $arr['product_image'] = $image;
            array_push($data,$arr);
        }
        return $data;
    }
    public function getWallet(){
        $data=[];
        $wallets = Product::where('product_type',2)->get();
        foreach ($wallets as $wallet){
            $image = $this->getImage($wallet->id);
            $arr = json_decode(json_encode($wallet),true);
            $arr['product_image'] = $image;
            array_push($data,$arr);
        }
        return $data;
    }
    public function getTote(){
        $data=[];
        $totes = Product::where('product_type',3)->get();
        foreach ($totes as $tote){
            $image = $this->getImage($tote->id);
            $arr = json_decode(json_encode($tote),true);
            $arr['product_image'] = $image;
            array_push($data,$arr);
        }
        return $data;
    }
    public function getCrossbody(){
        $data=[];
        $crossbodys = Product::where('product_type',4)->get();
        foreach ($crossbodys as $crossbody){
            $image = $this->getImage($crossbody->id);
            $arr = json_decode(json_encode($crossbody),true);
            $arr['product_image'] = $image;
            array_push($data,$arr);
        }
        return $data;
    }

    public function getImage($id)
    {
        $data = [];
        $images = ImageProduct::where('product_id',$id)->get();
        foreach ($images as $image)
            array_push($data,$image->image_link);
        return $data;
    }

}
