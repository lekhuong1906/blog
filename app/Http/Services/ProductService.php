<?php

namespace App\Http\Services;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService extends ProcessService
{
    public function createProduct($data)
    {
        $product = new Product();
        $product->fill($data->all());
    }

    public function getAllProduct()
    {
        $data = [];
        $color_list = [];
        $allProduct = Product::all();
        foreach ($allProduct as $product) {
            $colors = DB::table('product_colors')->where('product_id', $product->id)->get();
            dd($colors);
            foreach ($colors as $color) {
                if ($color->product_stock !== 0) {
                    $color_value = Color::where('id', $color->color_id)->first();
                    array_push($color_list, $color_value->color_code);
                }
            }
            $tamp = json_decode(json_encode($product), true);
            $tamp['color_code'] = $color_list;
            array_push($data,$tamp);
        }
        return $this->formatJson($data);
    }
}
