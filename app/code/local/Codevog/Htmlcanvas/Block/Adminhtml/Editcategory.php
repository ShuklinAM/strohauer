<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editcategory extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_mode = 'editcategory';
        $this->_controller = 'adminhtml';

        $category_id = (int)$this->getRequest()->getParam('id');


        if($category_id)
        {
            $this->_updateButton('delete','label',Mage::helper('codevog_htmlcanvas')->__('Delete Pic Category'));
            $this->_updateButton('delete','onclick', "
                    if(confirm('".Mage::helper('codevog_htmlcanvas')->__('Delete Current Pic Category?')."'))
                    {
                        setLocation('".$this->getUrl('*/*/deletepiccategory/id/'.$category_id)."')
                    }
                       ");

            //$this->_removeButton('delete');
        }
        $this->_updateButton('back','onclick',"setLocation('".$this->getUrl('*/*/picscategories')."')");

        $category = Mage::getModel('htmlcanvas/piccategory')->load($category_id);

        Mage::register('current_piccategory', $category);
    }

    public function getHeaderText()
    {
        $category = Mage::registry('current_piccategory');
        if ($category->getId()) {
            return Mage::helper('codevog_htmlcanvas')->__("Edit Pic Category");
        } else {
            return Mage::helper('codevog_htmlcanvas')->__("Add Pic Category");
        }
    }
}
?>