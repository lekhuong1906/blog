<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Services\AddressService;
use Illuminate\Support\Collection;

class AddressController extends Controller
{
    protected $service;
    public function __construct(AddressService $addressService)
    {
        $this->service = $addressService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return new Collection($this->service->showAllAddress());
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return Collection
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->service->addNewAddress($request);
        return response()->json([
            'message'=>'Add new Address Success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Collection
     */
    public function show($id)
    {
        $address = Address::find($id);
        return new Collection($address);
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
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->service->updateAddress($request,$id);
        return response()->json([
            'message'=>'Updated Address Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        $address = Address::find($id);

        if (!$address)
            return response()->json(['message' => 'Address not found'], 404);

        $address->delete();

        return response()->json(['message' => 'Address deleted successfully'], 200);

    }
}
