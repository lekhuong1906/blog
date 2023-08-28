<?php

namespace App\Http\Services;

use App\Models\ImageProduct;
use App\Models\Product;
use App\Models\ProductDescription;
use Illuminate\Support\Facades\Validator;


class ProductService extends ImageProductService
{

    #Index
    public function getAllProduct()
    {

        $products = Product::all();
        $data = [];
        foreach ($products as $product)
            array_push($data, $this->productDetail($product->id));

        return $data;
    }

    #Store
    public function createProduct($request)
    {
        try {

            $product = new Product(); // Create New Product
            $product->fill($request->all());
            $product->save();


            $this->createImage($request, $product->id); // Create Product Images

            $this->createProductDescription($request, $product->id);

            return 'Add Product Success';

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    #Show
    public function productDetail($id)
    {
        $product = Product::find($id);
        $data = json_decode(json_encode($product), true);

        $detail = ProductDescription::where('product_id', $product->id)->first();
        $data['introduce'] = $detail->introduce;
        $data['material'] = $detail->material;
        $data['size'] = $detail->size;
        $data['contain'] = $detail->contain;
        $data['other'] = $detail->other;

        $images = ImageProduct::where('product_id', $id)->get();
        foreach ($images as $image) {
            $data['product_images'] = explode(',', $image->image_link);
        }

        return $data;
    }

    #Update
    public function updateProduct($request,$product_id){
        $validate = Validator::make($request->all(),[
            'product_name' => 'required',
            'product_type' => 'required|numeric',
            'product_price' => 'required|numeric',
            'product_stock' => 'required|numeric',
            'status'=>'required',

            'introduce' => 'required',
            'material' => 'required',
            'size' => 'required',
            'contain' => 'required',
        ]);

        if ($validate->fails())
            return $validate->errors();

        $this->updateTableProduct($request,$product_id);
        $this->updateTableProductDescription($request,$product_id);
        return 'Updated Product Successfully';
    }

    public function updateTableProduct($request,$product_id){
        $product = Product::find($product_id);
        $product->fill($request->all());
        $product->save();
    }

    public function updateTableProductDescription($request,$product_id){
        $product_description = ProductDescription::where('product_id',$product_id)->first();
        $product_description->fill($request->all());
        $product_description->save();
    }

    public function createProductDescription($request, $product_id)
    {
        $description = new ProductDescription();
        $description->product_id = $product_id;
        $description->introduce = $request->introduce;
        $description->material = $request->material;
        $description->size = $request->size;
        $description->contain = $request->contain;
        $description->other = $request->other;
        $description->save();
    }

    public function getBackPack()
    {
        $data = [];
        $backpacks = Product::where('product_type', 1)->get();
        foreach ($backpacks as $backpack) {
            $arr = $this->productDetail($backpack->id);
            array_push($data, $arr);
        }
        return $data;
    }

    public function getWallet()
    {
        $data = [];
        $wallets = Product::where('product_type', 2)->get();
        foreach ($wallets as $wallet) {
            $arr = $this->productDetail($wallet->id);
            array_push($data, $arr);
        }
        return $data;
    }

    public function getTote()
    {
        $data = [];
        $totes = Product::where('product_type', 3)->get();
        foreach ($totes as $tote) {
            $arr = $this->productDetail($tote->id);
            array_push($data, $arr);
        }
        return $data;
    }

    public function getCrossbody()
    {
        $data = [];
        $crossbodys = Product::where('product_type', 4)->get();
        foreach ($crossbodys as $crossbody) {
            $arr = $this->productDetail($crossbody->id);
            array_push($data, $arr);
        }
        return $data;
    }

    public function getImage($id)
    {
        $images = ImageProduct::where('product_id', $id)->get();
        foreach ($images as $image)
            $data = explode(',', $image->image_link);
        return $data;
    }


}
