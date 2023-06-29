<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageProductRequest;
use App\Http\Services\ImageProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ImageProduct;


class ImageProductController extends Controller
{
    protected $data;
    public function __construct(ImageProductService $imageProductService)
    {
        return $this->data = $imageProductService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return false|\Illuminate\Http\Response|string
     */
    public function index()
    {
        $files = Storage::allFiles('public/products');

        $imageUrls = [];

        foreach ($files as $file) {
            $imageUrls[] = asset('storage/'.str_replace('public/', '', $file));
        }
        return $this->data->formatJson($imageUrls);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageProductRequest $request)
    {
        try {
            $image = Str::random(32) . "." . $request->image->getClientOriginalExtension();
            ImageProduct::create([
                'product_id' => $request->product_id,
                'image_product_name' => $request->image_product_name,
                'image' => $image,
                'image_product_description' => $request->image_product_description
            ]);

            Storage::putFileAs('public/products', $request->file('image'), $image);


            return response()->json([
                'message' => 'Success.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return false|\Illuminate\Http\Response|string
     */
    public function show($id)
    {
        $products = ImageProduct::where('product_id',$id)->get();


        $files = Storage::allFiles('public/sliders');
        $imageUrls = [];
        foreach ($files as $file) {
            $imageUrls[] = asset('storage/'.str_replace('public/', '', $file));
        }
        return $this->data->formatJson($imageUrls);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
