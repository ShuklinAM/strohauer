<?php

class Codevog_Delivery_Block_Adminhtml_Editminimumdays extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
         
        $this->_blockGroup = 'codevog_delivery';
        $this->_mode = 'editminimumdays';
        $this->_controller = 'adminhtml';
       parent::__construct();
      $this->_removeButton('delete');
      $this->_removeButton('back');
        
        
       $num_id = (int)$this->getRequest()->getParam('id');
       
        $num = Mage::getModel('delivery/minimumdays')->load($num_id);
       
        Mage::register('current_minimumdays', $num);
        
        
      
    }
 
    public function getHeaderText()
    {
       $num = Mage::registry('current_minimumdays');
        if ($num->getId()) { 
            return Mage::helper('codevog_delivery')->__("Edit minimum days of delivery");
        } else {
            return Mage::helper('codevog_delivery')->__("");
        }
    }
}
?>