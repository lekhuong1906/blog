<?php


namespace App\Http\Services;


use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class PaymentService
{
    private $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function createToken(Request $request)
    {
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => date("m", strtotime($request->exp_date)),
                    'exp_year' => date("Y", strtotime($request->exp_date)),
                    'cvc' => $request->cvv,
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        } catch (ApiErrorException $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }
    public function createCharge($tokenId, $amount)
    {
        $charge = null;
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $amount,
                'currency' => 'usd',
                'source' => $tokenId,
                'description' => 'My first payment'
            ]);
        } catch (Exception $e) {
            $charge['error'] = $e->getMessage();
        }
        return $charge;
    }

}
