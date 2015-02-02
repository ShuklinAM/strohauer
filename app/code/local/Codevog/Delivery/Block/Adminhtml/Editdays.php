<?php

class Codevog_Delivery_Block_Adminhtml_Editdays extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
         
        $this->_blockGroup = 'codevog_delivery';
        $this->_mode = 'editdays';
        $this->_controller = 'adminhtml';
       parent::__construct();
      $this->_removeButton('delete');
      $this->_removeButton('back');
        
        
       $day_id = (int)$this->getRequest()->getParam('id');
       
        $day = Mage::getModel('delivery/days')->load($day_id);
       
        Mage::register('current_days', $day);
        
        
      
    }
 
    public function getHeaderText()
    {
       $day = Mage::registry('current_days');
        if ($day->getId()) { 
            return Mage::helper('codevog_delivery')->__("Edit weekends of delivery");
        } else {
            return Mage::helper('codevog_delivery')->__("");
        }
    }
}
?>