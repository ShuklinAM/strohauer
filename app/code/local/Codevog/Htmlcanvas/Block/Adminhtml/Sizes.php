<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Sizes extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_sizes';
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_headerText = Mage::helper('codevog_htmlcanvas')->__('View sizes');

        $this->_updateButton('add','label' , Mage::helper('codevog_htmlcanvas')->__('Add Size'));
        $this->_updateButton('add','onclick' ,"setLocation('".$this->getUrl('*/*/addsize')."')" );

        //$this->_removeButton('add');
    }
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('codevog_htmlcanvas/adminhtml_sizes_grid', 'sizes.grid'));
        return parent::_prepareLayout();
    }

}