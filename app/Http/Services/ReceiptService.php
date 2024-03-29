<?php


namespace App\Http\Services;


use App\Mail\MailSuccess;
use App\Models\Address;
use App\Models\Cart;
use App\Models\ImageProduct;
use App\Models\Order;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;


class ReceiptService extends OrderService
{
    protected $data = []; //Array containing invoice information

    public function showAllReceipt()
    {  //For admin
        $receipts = Receipt::all();
        $items = array();
        foreach ($receipts as $receipt) {
            $items[] = $this->showReceiptDetail($receipt->id);
        }
        return $items;
    }

    public function showAllReceiptCustomer()
    {
        $user_id = auth()->id();
        $receipts = Receipt::where('user_id', $user_id)->get();
        if (empty($receipts))
            return null;
        $items = array();
        foreach ($receipts as $receipt) {
            $items[] = $this->showReceiptDetail($receipt->id);
        }
        return $items;
    }


    public function addNewReceipt($request)
    {

        $cart_id = $request->cart_id;
        $user_id = $request->user_id;

        $cart = Cart::find($cart_id);
        $total_amount = $cart->total_price;

        $new_receipt = new Receipt();
        $new_receipt->user_id = $user_id;
        $new_receipt->receiver_name = $request->receiver_name;
        $new_receipt->contact_number = $request->contact_number;
        $new_receipt->specific_address = $request->specific_address;
        $new_receipt->total_amount = $total_amount;
        $new_receipt->save();

        $receipt_id = $new_receipt->id;
        $this->addNewOrder($cart, $receipt_id);

        #Send mail
        $data = $this->showReceiptDetail($receipt_id);

        Mail::to($data['email'])->send(new MailSuccess($data));
    }


    public function updateReceiptStatus($request, $id)
    {
        try {
            $receipt = Receipt::find($id);

            if (!$receipt)
                return 'Receipt Not Found';

            $receipt->fill($request->all());
            $receipt->save();

            return 'Updated Successfully';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function showReceiptDetail($id)
    {
        $receipt = Receipt::find($id);

        $this->getUserDetail($receipt->user_id);
        $this->getOrderDetail($id);
        $this->getAddressDetail($receipt->id);
        $this->getReceiptDetail($id);

        return json_decode(json_encode($this->data), true);
    }

    public function deleteReceipt($id)
    {
        try {
            $receipt = Receipt::find($id);
            $receipt->delete();

            $orders = Order::where('receipt_id', $id)->get();
            foreach ($orders as $order) {
                $order->delete();
            }

            return 'Deleted Successfully';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUserDetail($user_id)
    {
        $user = User::find($user_id);
        $this->data['user_id'] = $user_id;
        $this->data['user_name'] = $user->name;
        $this->data['email'] = $user->email;
    }

    public function getAddressDetail($receipt_id)
    {
        $receipt = Receipt::find($receipt_id);
        $this->data['receipt_id'] = $receipt_id;
        $this->data['receiver_name'] = $receipt->receiver_name;
        $this->data['contact_number'] = $receipt->contact_number;
        $this->data['specific_address'] = $receipt->specific_address;
    }

    public function getReceiptDetail($receipt_id)
    {
        $receipt = Receipt::find($receipt_id);
        $this->data['total_amount'] = $receipt->total_amount;
        $this->data['receipt_status'] = $receipt->status;
        $this->data['created_at'] = $receipt->created_at;
    }

    public function getOrderDetail($receipt_id)
    {
        $this->data['order_detail'] = $this->getProductDetail($receipt_id);
    }
}
