<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageProductRequest;
use App\Http\Services\ImageProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ImageProduct;


class ImageProductController extends Controller
{
    protected $service;
    public function __construct(ImageProductService $imageProductService)
    {
        return $this->service = $imageProductService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return false|\Illuminate\Http\Response|string
     */
    public function index()
    {

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
        $message = $this->service->createImage($request);
        return response()->json(['message'=>$message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $productId
     * @return false|\Illuminate\Http\Response|string
     */
    public function show(int $productId)
    {
        $images_link = $this->service->showImage($productId);
        return new Collection($images_link);
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
