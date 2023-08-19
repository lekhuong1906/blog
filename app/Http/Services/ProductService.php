<?php

namespace App\Http\Services;

use App\Models\ImageProduct;
use App\Models\Product;
use App\Models\ProductDescription;


class ProductService extends ProcessService
{

    public function createProduct($data)
    {
        $product = new Product();
        $product->fill($data->all());
        $product->save();

        route('import-product');

        return $this->formatJson(Product::all());
    }


    public function getAllProduct(){

        $products = Product::all();
        $data = [];
        foreach ($products as $product)
            array_push($data,$this->productDetail($product->id));

        return $data;
    }

    public function productDetail($id){
        $product = Product::find($id);
        $data = json_decode(json_encode($product),true);

        $detail = ProductDescription::find($product->product_description_id);
        $data['introduce'] = $detail->introduce;
        $data['material'] = $detail->material;
        $data['size'] = $detail->size;
        $data['contain'] = $detail->contain;
        $data['other'] = $detail->other;

        $images = ImageProduct::where('product_id',$id)->get();
        foreach ($images as $image){
            $data['product_images'] = explode(',',$image->image_link);
        }

        return $data;
    }

    public function getBackPack(){
        $data=[];
        $backpacks = Product::where('product_type',1)->get();
        foreach ($backpacks as $backpack){
            $arr = $this->productDetail($backpack->id);
            array_push($data,$arr);
        }
        return $data;
    }
    public function getWallet(){
        $data=[];
        $wallets = Product::where('product_type',2)->get();
        foreach ($wallets as $wallet){
            $arr = $this->productDetail($wallet->id);
            array_push($data,$arr);
        }
        return $data;
    }
    public function getTote(){
        $data=[];
        $totes = Product::where('product_type',3)->get();
        foreach ($totes as $tote){
            $arr = $this->productDetail($tote->id);
            array_push($data,$arr);
        }
        return $data;
    }
    public function getCrossbody(){
        $data=[];
        $crossbodys = Product::where('product_type',4)->get();
        foreach ($crossbodys as $crossbody){
            $arr = $this->productDetail($crossbody->id);
            array_push($data,$arr);
        }
        return $data;
    }

    public function getImage($id)
    {
        $images = ImageProduct::where('product_id',$id)->get();
        foreach ($images as $image)
            $data = explode(',',$image->image_link);
        return $data;
    }

}
