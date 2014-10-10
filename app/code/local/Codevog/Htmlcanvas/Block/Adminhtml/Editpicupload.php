<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editpicupload extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_mode = 'editpicupload';
        $this->_controller = 'adminhtml';

        $pic_id = (int)$this->getRequest()->getParam('id');


        if($pic_id)
        {
            $this->_updateButton('delete','label',Mage::helper('codevog_htmlcanvas')->__('Delete Pic'));
            $this->_updateButton('delete','onclick', "
                    if(confirm('".Mage::helper('codevog_htmlcanvas')->__('Delete Current Pic?')."'))
                    {
                        setLocation('".$this->getUrl('*/*/deletepicupload/id/'.$pic_id)."')
                    }
                       ");

            //$this->_removeButton('delete');
        }
        $this->_updateButton('back','onclick',"setLocation('".$this->getUrl('*/*/picsupload')."')");

        $pic = Mage::getModel('htmlcanvas/pics')->load($pic_id);

        Mage::register('current_pic', $pic);
    }

    public function getHeaderText()
    {
        $pic = Mage::registry('current_pic');
        if ($pic->getId()) {
            return Mage::helper('codevog_htmlcanvas')->__("Edit Pic");
        } else {
            return Mage::helper('codevog_htmlcanvas')->__("Add Pic");
        }
    }
}
?>