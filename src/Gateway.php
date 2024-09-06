<?php 

namespace Omnipay\Paddle;

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
            'productId' => '',
            'testMode' => true
        ];
    }

    /**
     * 
    */
    public function purchase(array $parameters = [])
    {
        
    }

    /**
     * 
    */
    public function completePurchase(array $parameters = [])
    {
        
    }
}