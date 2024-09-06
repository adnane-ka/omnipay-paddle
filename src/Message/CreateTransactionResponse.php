<?php 

namespace Omnipay\Paddle\Message;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class CreateTransactionResponse extends AbstractResponse implements RedirectResponseInterface
{
    /***/
    public function isSuccessful(){
        return !array_key_exists('error', $this->data);
    }

    /***/
    public function isRedirect(){
        return !array_key_exists('error', $this->data);
    }
    
    /***/
    public function getRedirectUrl(){
        $priceId = $this->data['data']['items'][0]['price']['id'];
        $productId = $this->data['data']['items'][0]['price']['product_id'];
        $transactionId = $this->data['data']['id'];
        $returnUrl = urldecode($this->data['returnUrl'] ."?transactionId=$transactionId");
        $fullUrl = $this->data['checkoutUrl']."?transactionId=$transactionId&returnUrl=$returnUrl";

        return $fullUrl;
    }

    /***/
    public function getMessage(){
        return $this->data['error']['code']
        .': '.$this->data['error']['detail']
        .'. request ID:'.$this->data['meta']['request_id'];
    }
}