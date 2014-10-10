<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editsubcategory extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_mode = 'editsubcategory';
        $this->_controller = 'adminhtml';

        $subcategory_id = (int)$this->getRequest()->getParam('id');


        if($subcategory_id)
        {
            $this->_updateButton('delete','label',Mage::helper('codevog_htmlcanvas')->__('Delete Pic Subcategory'));
            $this->_updateButton('delete','onclick', "
                    if(confirm('".Mage::helper('codevog_htmlcanvas')->__('Delete Current Pic Subcategory?')."'))
                    {
                        setLocation('".$this->getUrl('*/*/deletepicsubcategory/id/'.$subcategory_id)."')
                    }
                       ");

            //$this->_removeButton('delete');
        }
        $this->_updateButton('back','onclick',"setLocation('".$this->getUrl('*/*/picssubcategories')."')");

        $subcategory = Mage::getModel('htmlcanvas/picsubcategory')->load($subcategory_id);

        Mage::register('current_picsubcategory', $subcategory);
    }

    public function getHeaderText()
    {
        $subcategory = Mage::registry('current_picsubcategory');
        if ($subcategory->getId()) {
            return Mage::helper('codevog_htmlcanvas')->__("Edit Pic Subcategory");
        } else {
            return Mage::helper('codevog_htmlcanvas')->__("Add Pic Subcategory");
        }
    }
}
?>