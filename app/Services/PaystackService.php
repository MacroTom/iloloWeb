<?php

namespace App\Services;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;

class PaystackService
{
    use ApiResponse;
    protected $url, $headers, $currency;

    public function __construct(){
        $this->url = 'https://api.paystack.co/';
        $this->currency = "NGN";
        $this->headers = [
            'Authorization' => 'Bearer '. env('PAYSTACK_SECRET_KEY'),
            'Content-Type' => 'application/json'
        ];
    }

    public function transactions(){
        return $response = Http::withHeaders($this->headers)
        ->get($this->url.'transaction');
    }

    public function banks(){
        return $response = Http::withHeaders($this->headers)
        ->get($this->url.'bank');
    }

    public function resolveAccount($account_number, $bank_code){
        $body = [
            'account_number' => $account_number,
            'bank_code' => $bank_code
        ];
        return $response = Http::withHeaders($this->headers)
        ->get($this->url.'bank/resolve',$body);
    }

    public function testCard($email,$amount,$cardDetails){
        $body = [
            'email' => $email,
            'amount' => floatval($amount) * 100,
            'currency' => $this->currency,
            'card' => [
                'number' => $cardDetails['card_number'],
                'cvv' => $cardDetails['cvv'],
                'expiry_month' => $cardDetails['expiry_month'],
                'expiry_year' => $cardDetails['expiry_year']
            ],
        ];

        return $response = Http::withHeaders($this->headers)
        ->post($this->url.'charge',$body);
    }

    public function refund($reference,$amount){
        $body = [
            'transaction' => $reference,
            'amount' => $amount * 100,
        ];
        return $response = Http::withHeaders($this->headers)
        ->post($this->url.'refund',$body);
    }

    public function charge($email, $amount, $authorization_code){
        $body = [
            'email' => $email,
            'amount' => $amount * 100,
            'currency' => $this->currency,
            'authorization_code' => $authorization_code,
        ];
        return $response = Http::withHeaders($this->headers)
        ->post($this->url.'transaction/charge_authorization',$body);
    }

    public function initialize($email, $amount, $metadata=[]){
        $body = [
            'email' => $email,
            'amount' => $amount * 100,
            'currency' => $this->currency,
            'metadata' => $metadata
        ];
        return Http::withHeaders($this->headers)
        ->post($this->url.'transaction/initialize',$body);
    }

    public function submitPin($pin, $reference){
        $body = [
            'pin' => $pin,
            'reference' => $reference
        ];

        return $response = Http::withHeaders($this->headers)
        ->post($this->url.'charge/submit_pin',$body);
    }

    public function submitOTP($otp, $reference){
        $body = [
            'otp' => $otp,
            'reference' => $reference
        ];

        return $response = Http::withHeaders($this->headers)
        ->post($this->url.'charge/submit_otp',$body);
    }

    public function verifyTransaction($reference){
        return $response = Http::withHeaders($this->headers)
        ->get($this->url.'transaction/verify/'.$reference);
        $response;
    }

    public function getCustomer($email){
        $body = [
            'email_or_code' => $email
        ];

        return $response = Http::withHeaders($this->headers)
        ->get($this->url.'customer',$body);
    }

    public function transferRecipient($account_name,$account_number,$bank_code)
    {
        $body = [
            'type' => 'nuban',
            'name' => $account_name,
            'account_number' => $account_number,
            'bank_code' => $bank_code,
            'currency' => 'NGN'
        ];

        return $response = Http::withHeaders($this->headers)
        ->post($this->url.'transferrecipient',$body);
    }

    public function transfer($amount,$recipient_code,$reason='Withdrawal by customer')
    {
        $body = [
            'source' => 'balance',
            'amount' => $amount * 100,
            'recipient' => $recipient_code,
            'reason' => $reason,
            'currency' => 'NGN'
        ];

        return $response = Http::withHeaders($this->headers)
        ->post($this->url.'transfer',$body);
    }

}
