<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editabout extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_mode = 'editabout';
        $this->_controller = 'adminhtml';

        $about_id = (int)$this->getRequest()->getParam('id');


        if($about_id)
        {
            $this->_removeButton('delete');
        }
        $this->_updateButton('back','onclick',"setLocation('".$this->getUrl('*/*/about')."')");

        $about = Mage::getModel('htmlcanvas/about')->load($about_id);

        Mage::register('current_about', $about);
    }

    public function getHeaderText()
    {
        $about = Mage::registry('current_about');
        if ($about->getId()) {
            return Mage::helper('codevog_htmlcanvas')->__("Edit Message");
        }
    }
}
?>