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
        $transactionId = $this->data['data']['id'];
        $returnUrl = urldecode($this->data['returnUrl']);
        $queryString = parse_url($returnUrl, PHP_URL_QUERY) ?? '';  // Get the query string from the URL
        parse_str($queryString, $queryParams);  // Parse the query string into an array
        $queryParams['transactionId'] = $transactionId;  // Add the transactionId to the array
        $fullUrl = $this->data['checkoutUrl'] . '?transactionId=' . $transactionId . '&returnUrl=' . urlencode($returnUrl . '?' . http_build_query($queryParams));
        
        return $fullUrl;
    }

    /***/
    public function getMessage(){
        return $this->data['error']['code']
        .': '.$this->data['error']['detail']
        .'. request ID:'.$this->data['meta']['request_id'];
    }
}