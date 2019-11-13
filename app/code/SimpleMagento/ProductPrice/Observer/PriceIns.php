<?php


namespace SimpleMagento\ProductPrice\Observer;


use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class PriceIns implements ObserverInterface
{


    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $item=$observer->getEvent()->getData('quote_item');

        $product=$observer->getEvent()->getData('product');

        // here i am using item's product final price
        $price = $item->getProduct()->getFinalPrice(); // 10 is custom price. It will increase in product price.
        $price1 = $price/10;
//         var_dump($price1);
//        var_dump($price);
        $price = $price + $price1;
//        var_dump($price);exit();
        // Set the custom price
        $item->setCustomPrice($price);
        $item->setOriginalCustomPrice($price);
        // Enable super mode on the product.
        $item->getProduct()->setIsSuperMode(true);


        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/templog.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('Price'.__METHOD__);
        return $this;

    }

}