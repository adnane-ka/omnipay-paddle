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
        return $this->buildRedirectUrl();
    }

    /***/
    public function getMessage(){
        return $this->data['error']['code']
        .': '.$this->data['error']['detail']
        .'. request ID:'.$this->data['meta']['request_id'];
    }

    public function buildRedirectUrl(){
        $transactionId = $this->data['data']['id'];
        $returnUrl = urldecode($this->data['returnUrl']);
        $checkoutUrl = $this->data['checkoutUrl'];
    
        // Parse query strings from both URLs
        $returnParams = [];
        $checkoutParams = [];
    
        parse_str(parse_url($returnUrl, PHP_URL_QUERY) ?? '', $returnParams);
        parse_str(parse_url($checkoutUrl, PHP_URL_QUERY) ?? '', $checkoutParams);
    
        // Add transactionId to both parameter sets
        $returnParams['transactionId'] = $transactionId;
        $checkoutParams['transactionId'] = $transactionId;
    
        // Rebuild the returnUrl and checkoutUrl
        $finalReturnUrl = strtok($returnUrl, '?') . '?' . http_build_query($returnParams, '', '&');  // Ensure & is used, not &amp;
        $finalCheckoutUrl = strtok($checkoutUrl, '?') . '?' . http_build_query($checkoutParams, '', '&');
    
        // Append the returnUrl as a parameter to the checkoutUrl
        $finalCheckoutUrl .= '&returnUrl=' . urlencode($finalReturnUrl);
    
        return $finalCheckoutUrl;
    }
}