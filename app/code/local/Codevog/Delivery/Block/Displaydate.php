<?php
class Codevog_Delivery_Block_Displaydate extends Mage_Core_Block_Template
{
    public function _construct()
    {
            parent::_construct();
            $this->setTemplate('codevog/delivery/displaydate.phtml');
    }
     public function displayDeliveryDate()
    {
        $displayDate = false;
 
       if($this->getOrder()->getCustomerNote() != NULL)
            $displayDate = true;
 
        return $displayDate;
    }
 
    public function getDisplayDeliveryDate()
    {
     
        $note = $this->getOrder()->getCustomerNote();
        return $note;
    }
    public function getDisplayDeliveryComment()
    {
     
        $order_id = (int)$this->getRequest()->getParam('order_id');
        $order_model = Mage::getModel('sales/order');
        $order = $order_model->load($order_id);
        $comments = $order->getCustomerComments();
        return $comments;
    }
 
    public function getOrder()
    {
        return Mage::registry('current_order');
    }
    
    
}
