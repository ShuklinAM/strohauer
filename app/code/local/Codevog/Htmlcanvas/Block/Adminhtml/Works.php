<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Works extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_works';
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_headerText = Mage::helper('codevog_htmlcanvas')->__('View User Works');

        $this->_removeButton('add');
    }
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('codevog_htmlcanvas/adminhtml_works_grid', 'works.grid'));
        return parent::_prepareLayout();
    }

}