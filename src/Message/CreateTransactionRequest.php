<?php 

namespace Omnipay\Paddle\Message;
use Omnipay\Common\Message\AbstractRequest;

class CreateTransactionRequest extends AbstractRequest
{
    /***/
    public function setAmount($value){
        $this->setParameter('amount', $value);
    }

    /***/
    public function setCheckoutUrl($value){
        $this->setParameter('checkoutUrl', $value);
    }

    /***/
    public function setReturnUrl($value){
        $this->setParameter('returnUrl', $value);
    }

    /***/
    public function setTestMode($value){
        $this->setParameter('testMode', $value);
    }

    /***/
    public function setCurrency($value){
        $this->setParameter('currency', $value);
    }

    /***/
    public function setApiKey($value){
        $this->setParameter('apiKey', $value);
    }

    /***/
    public function getApiBaseUrl(){
        return $this->getParameter('testMode')
        ? 'https://sandbox-api.paddle.com'
        : 'https://api.paddle.com';
    }

    /***/
    public function getEndpoint(){
        return $this->getApiBaseUrl() . '/transactions';
    }

    /***/
    public function getData()
    {
        // @see https://developer.paddle.com/api-reference/transactions/create-transaction#request-body
        $data = [
            'items' => [
                [
                    'price' => [
                        'description' => 'Description',
                        'unit_price' => [
                            'amount' => (string) $this->getParameter('amount'),
                            'currency_code' => $this->getParameter('currency')
                        ],
                        'product' => [
                            'name' => uniqid(),
                            'tax_category' => 'standard'
                        ]
                    ],
                    'quantity' => 1  
                ]  
            ]
        ];
        
        return $data;
    }

    /***/
    public function sendData($data){
        $httpResponse = $this->httpClient->request('POST', $this->getEndPoint(), [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$this->getParameter('apiKey')}"
        ], json_encode($data));

        return $this->response = new CreateTransactionResponse($this, array_merge(
            json_decode($httpResponse->getBody()->getContents(), true), 
            [
                'checkoutUrl' => $this->getParameter('checkoutUrl'),
                'returnUrl' => $this->getParameter('returnUrl')
            ]
        ));
    }
}