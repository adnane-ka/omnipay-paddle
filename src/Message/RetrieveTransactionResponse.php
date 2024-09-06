<?php 

namespace Omnipay\Paddle\Message;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class RetrieveTransactionResponse extends AbstractResponse 
{
    /**
     * @return boolean
    */
    public function isSuccessful()
    {
        // @see https://developer.paddle.com/api-reference/transactions/get-transaction#get-a-transaction
        return !array_key_exists('error', $this->data) && $this->data['data']['status'] == 'completed';
    }

    /**
     * @return string
    */
    public function getTransactionReference(){
        return $this->data['data']['id'];
    }

    /***/
    public function getMessage(){
        return "No transaction could be located";
    }
}