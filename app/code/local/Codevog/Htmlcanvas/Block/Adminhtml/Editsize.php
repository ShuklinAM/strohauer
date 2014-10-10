<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editsize extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_mode = 'editsize';
        $this->_controller = 'adminhtml';

        $size_id = (int)$this->getRequest()->getParam('id');


        if($size_id)
        {
            $this->_updateButton('delete','label',Mage::helper('codevog_htmlcanvas')->__('Delete Size'));
            $this->_updateButton('delete','onclick', "
                    if(confirm('".Mage::helper('codevog_htmlcanvas')->__('Delete Current Size?')."'))
                    {
                        setLocation('".$this->getUrl('*/*/deletesize/id/'.$size_id)."')
                    }
                       ");

            //$this->_removeButton('delete');
        }
        $this->_updateButton('back','onclick',"setLocation('".$this->getUrl('*/*/sizes')."')");

        $size = Mage::getModel('htmlcanvas/sizes')->load($size_id);

        Mage::register('current_size', $size);

    }

    public function getHeaderText()
    {
        $size = Mage::registry('current_size');
        if ($size->getId()) {
            return Mage::helper('codevog_htmlcanvas')->__("Edit Size");
        } else {
            return Mage::helper('codevog_htmlcanvas')->__("Add Size");
        }
    }
}
?>