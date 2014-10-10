<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Subcategories extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_subcategories';
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_headerText = Mage::helper('codevog_htmlcanvas')->__('View Pic Subcategories');

        $this->_updateButton('add','label' , Mage::helper('codevog_htmlcanvas')->__('Add Pic Subcategory'));
        $this->_updateButton('add','onclick' ,"setLocation('".$this->getUrl('*/*/addpicsubcategory')."')" );

        //$this->_removeButton('add');
    }
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('codevog_htmlcanvas/adminhtml_subcategories_grid', 'subcategories.grid'));
        return parent::_prepareLayout();
    }

}