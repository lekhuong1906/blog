<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Http\Requests\TypeRequest;
use App\Http\Services;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Services\ProductService;

class TypeController extends Controller
{

    protected $service;
    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return false|string
     */

    public function index()
    {
        return new Collection(Type::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Type $type,TypeRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(TypeRequest $request)
    {
        $type = new Type();
        $type->fill($request->all());
        $type->save();

        return new Collection(Type::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return false|string
     */
    public function show($type_name)
    {
        switch ($type_name) {
            case 'backpacks': $data = $this->service->getBackPack();
                break;

            case 'wallets': $data = $this->service->getWallet();
                break;
            case 'crossbodies': $data = $this->service->getCrossbody();
                break;
            case 'totes': $data = $this->service->getTote();
                break;
        }

        return new Collection($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return false|string
     */
    public function update(TypeRequest $request,$id)
    {
        $type = Type::find($id);
        $type->fill($request->all());
        $type->save();

        return $this->data->formatJson($type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return false|\Illuminate\Http\Response|string
     */
    public function destroy($id)
    {
        $type = Type::find($id);
        $type->delete();

        return $this->data->formatJson(Type::all());
    }
}
