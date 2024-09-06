<?php 

namespace Omnipay\Paddle\Message;
use Omnipay\Common\Message\AbstractRequest;

class RetrieveTransactionRequest extends AbstractRequest
{
    /***/
    public function setTransactionId($value){
        $this->setParameter('transactionId', $value);
    }

    /***/
    public function getApiBaseUrl(){
        return $this->getParameter('testMode')
        ? 'https://sandbox-api.paddle.com'
        : 'https://api.paddle.com';
    }

    /***/
    public function setApiKey($value){
        $this->setParameter('apiKey', $value);
    }

    /***/
    public function getEndpoint(){
        return $this->getApiBaseUrl() . "/transactions/". $this->getParameter('transactionId');
    }

    /***/
    public function getData(){
        return [];
    }
    
    /***/
    public function sendData($data){
        $httpResponse = $this->httpClient->request('GET', $this->getEndPoint(), [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$this->getParameter('apiKey')}"
        ]);

        return $this->response = new RetrieveTransactionResponse($this, json_decode($httpResponse->getBody()->getContents(), true));
    }
}