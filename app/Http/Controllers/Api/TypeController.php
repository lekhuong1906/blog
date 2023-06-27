<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Http\Requests\TypeRequest;
use App\Http\Services;

class TypeController extends Controller
{

    protected $data;
    public function __construct(Services\ProcessService $process_service)
    {
        $this->data = $process_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return false|string
     */

    public function index()
    {
        return $this->data->formatJson(Type::paginate(4));
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

        return $this->data->formatJson(Type::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return false|string
     */
    public function show($id)
    {
        return $this->data->formatJson(Type::find($id));
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
