<?php

namespace Amasty\DpankoExtend\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Session;

class UpdateCart implements ObserverInterface
{
    /**
     * @var Session
     */
    public Session $session;


    public function execute(Observer $observer)
    {


        $promoSKUObject = $observer->getpromoSKUObject();
        $promo = $promoSKUObject->getData('promoSKUObject');
        $quote = $this->session->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }

        $quote->addProduct($promo, 1);
        $quote->save();
    }


}