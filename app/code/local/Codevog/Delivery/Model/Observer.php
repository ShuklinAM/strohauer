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

class Codevog_Delivery_Model_Observer
{
    public function saveComment($observer) {

        $enable_date = Mage::helper('codevog_delivery')->getConfig('enable_date');
        
 
        if ($enable_date)	{

            $orderComment = $observer->getEvent()->getRequest()->getPost('customer_notes');
            $deliveryComment = $observer->getEvent()->getRequest()->getPost('deliverycomment');

            $orderComment = trim($orderComment);

            if ($orderComment != "") {
              
                $observer->getEvent()->getQuote()->getShippingAddress()->setCustomerNotes($orderComment)->save();
                
         
                Mage::getSingleton('checkout/session')->setCustomerComments($deliveryComment);
                
            }
        }

    }
     public function Deliverycomment($observer){
         $enable_date = Mage::helper('codevog_delivery')->getConfig('enable_date');
        
 
      if ($enable_date)	{
            $event = $observer->getEvent();

                    //get order
            $order = $event->getOrder();
            $customerComments = Mage::getSingleton('checkout/session')->getCustomerComments();

            $order->setCustomerComments($customerComments);
       
        }   
     }
    
    
    
}