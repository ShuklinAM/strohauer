<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Categories extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_categories';
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_headerText = Mage::helper('codevog_htmlcanvas')->__('View Pic Categories');

        $this->_updateButton('add','label' , Mage::helper('codevog_htmlcanvas')->__('Add Pic Category'));
        $this->_updateButton('add','onclick' ,"setLocation('".$this->getUrl('*/*/addpiccategory')."')" );

        //$this->_removeButton('add');
    }
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('codevog_htmlcanvas/adminhtml_categories_grid', 'categories.grid'));
        return parent::_prepareLayout();
    }

}