<?php
/**
 * Magebase
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * @category    Magebase
 * @package     Magebase_CheckoutComment
 * @copyright   Copyright (c) 2011 Magebase. (http://magebase.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class Codevog_Htmlcanvas_Model_Observer
{
    
     public function setBuildOptions($observer){
    
            $event = $observer->getEvent();

            $order = $event->getOrder();
         
            $orderId = $order->getRealOrderId();
  
            $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);

            $items = $order->getAllVisibleItems();

            $ip = Mage::helper('core/http')->getRemoteAddr(false);

            foreach($items as $item)
            {
                $buildModel = Mage::getModel('htmlcanvas/works');
                $build = $buildModel->getCollection()->addFieldToFilter('item_id', $item->getProduct()->getId())->addFieldToFilter('ip',$ip)->addFieldToFilter('done',0)->getFirstItem();

               if($build->getId())
               {
                    $build->setDone(1);
                    $build->setOrderId($orderId);
                    $build->save();
               }
            }
     }
    public function applySize(Varien_Event_Observer $observer)
    {
        // @var $item Mage_Sales_Model_Quote_Item
        $item = $observer->getQuoteItem();
        if ($item->getParentItem()) {
            $item = $item->getParentItem();
        }
        $build = Mage::helper('codevog_htmlcanvas')->getBuildByIp($item->getProductId());
        if($build)
        {
            $size = Mage::getModel('htmlcanvas/sizes')->load($build->getSizeId());
            if ($size->getId()) {
                $productModel = Mage::getModel('catalog/product');
                $realItem = $productModel->load($item->getProductId());
                $specialPrice = round($realItem->getPrice() + $size->getPriceRule(),2);
                $item->setCustomPrice($specialPrice);
                $item->setOriginalCustomPrice($specialPrice);
                $item->getProduct()->setIsSuperMode(true);
            }
        }
    }
    public function applySizes(Varien_Event_Observer $observer)
    {
        foreach ($observer->getCart()->getQuote()->getAllVisibleItems() as $item) {
            if ($item->getParentItem()) {
                $item = $item->getParentItem();
            }
            $build = Mage::helper('codevog_htmlcanvas')->getBuildByIp($item->getProductId());
            if($build)
            {
                $size = Mage::getModel('htmlcanvas/sizes')->load($build->getSizeId());
                if ($size->getId()) {
                    $productModel = Mage::getModel('catalog/product');
                    $realItem = $productModel->load($item->getProductId());
                    $specialPrice = round($realItem->getPrice() + $size->getPriceRule(),2);
                    $item->setCustomPrice($specialPrice);
                    $item->setOriginalCustomPrice($specialPrice);
                    $item->getProduct()->setIsSuperMode(true);
                }
            }
        }
    }
}