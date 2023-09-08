<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Http\Services\ReceiptService;
use Illuminate\Support\Collection;

class ReceiptController extends Controller
{
    protected $service;
    public function __construct(ReceiptService $receiptService)
    {
        $this->service = $receiptService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        $data = $this->service->showAllReceipt();
        return new Collection($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function allReceiptCustomer()
    {
        $data = $this->service->showAllReceiptCustomer();
        if ($data == null)
            $data = ['message'=>'Receipt is Empty!'];
        return new Collection($data);
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
    public function store(Request $request)
    {
        $this->service->addNewReceipt($request);
        return response()->json(['message'=>'Add Receipt Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Collection
     */
    public function show($id)
    {
        return new Collection ($this->service->showReceiptDetail($id));
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
        $message = $this->service->updateReceiptStatus($request,$id);
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
        $message = $this->service->deleteReceipt($id);
        return response()->json([
            'message'=>$message,
        ]);
    }

    public function search(Request $request){
        $search_item = $request->input('search');

        $receipts = Receipt::where('receiver_name', 'LIKE', '%'.$search_item.'%')
            ->orWhere('contact_number', 'LIKE', '%'.$search_item.'%')
            ->get();
        foreach ($receipts as $receipt){
            $data [] = $this->service->showReceiptDetail($receipt->id);
        }
        return new Collection($data);
    }

    public function updateStatus($id){
        $receipt = Receipt::find($id);
        $receipt->status = 1;
        $receipt->save();

        return response()->json(['message'=>'Update Successfully']);
    }
}
