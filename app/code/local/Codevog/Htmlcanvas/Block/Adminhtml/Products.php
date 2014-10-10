<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Products extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_mode = 'products';
        $this->_controller = 'adminhtml';

        $this->_removeButton('delete');

        $this->_updateButton('back','onclick',"setLocation('".$this->getUrl('*/*/products')."')");

    }

    public function getHeaderText()
    {
        return Mage::helper('codevog_htmlcanvas')->__("Choose Products For Drawing");
    }
}