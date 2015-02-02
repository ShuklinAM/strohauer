<?php
class Codevog_Delivery_Block_Adminhtml_Minimumdays extends Mage_Adminhtml_Block_Widget_Grid_Container
{
     public function __construct()
    {
      $this->_controller = 'adminhtml_minimumdays';
      $this->_blockGroup = 'codevog_delivery';
      $this->_headerText = Mage::helper('codevog_delivery')->__('Set minimum days of delivery');
      parent::__construct();
      $this->_removeButton('add');
     
    } 
}