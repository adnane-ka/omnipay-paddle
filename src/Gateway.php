<?php 

namespace Omnipay\Paddle;
use Omnipay\Paddle\Message\CreateTransactionRequest;
use Omnipay\Paddle\Message\RetrieveTransactionRequest;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway{
    public function getName()
    {
        return 'Paddle';
    }

    public function getDefaultParameters()
    {
        return [
            'apiKey' => '',
            'testMode' => true
        ];
    }

    /*** */
    public function setApiKey($value){
        $this->setParameter('apiKey', $value);
    }

    /*** */
    public function setTestMode($value){
        $this->setParameter('testMode', $value);
    }

    /****/
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(CreateTransactionRequest::class, $parameters);
    }

    /**
     * 
    */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest(RetrieveTransactionRequest::class, $parameters);
    }
}