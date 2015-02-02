<?php
class Codevog_Delivery_Block_Adminhtml_Deliveryview extends Mage_Adminhtml_Block_Template
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('codevog/delivery/adminhtml/deliveryview.phtml');
        
    }
     public function displayDeliveryDate()
    {
        $displayDate = false;
        $order_id = (int)$this->getRequest()->getParam('order_id');
        $order_model = Mage::getModel('sales/order');
        $order = $order_model->load($order_id);
         $note = $order->getCustomerNote();
       if($note != NULL)
            $displayDate = true;
 
        return $displayDate;
    }
    public function get_Deliverydate()
    {
        $order_id = (int)$this->getRequest()->getParam('order_id');
        $order_model = Mage::getModel('sales/order');
        $order = $order_model->load($order_id);
        
        $note = $order->getCustomerNote();
       
        return $note;
    }
    public function get_Deliverycomment()
    {
        $order_id = (int)$this->getRequest()->getParam('order_id');
        $order_model = Mage::getModel('sales/order');
        $order = $order_model->load($order_id);
        
        $note = $order->getCustomerComments();
       
        return $note;
    }
}
?>