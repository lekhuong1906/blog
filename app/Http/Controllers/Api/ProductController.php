<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Models\ProductDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    protected $service;
    public function __construct(ProductService $productService )
    {
        return $this->service = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array|false|string
     */
    public function index()
    {
        return new Collection($this->service->getAllProduct());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return false|\Illuminate\Http\Response|string
     */
    public function store(ProductRequest $request)
    {
        $message = $this->service->createProduct($request);
        return response()->json(['message'=>$message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return false|\Illuminate\Http\Response|string
     */
    public function show($id)
    {
        return new Collection($this->service->productDetail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $message = $this->service->updateProduct($request,$id);
        return response()->json(['message'=>$message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        $product_detail = ProductDescription::where('product_id',$id)->first();
        $product_detail->delete();
        return response()->json([
            'message'=>'Deleted Product Successfully',
        ]);
    }

    public function search(Request $request){
        $search_item = $request->input('product_name');
        $products = Product::where('product_name', 'like', '%' . $search_item . '%')->get();

        return new Collection($products);
    }
}
