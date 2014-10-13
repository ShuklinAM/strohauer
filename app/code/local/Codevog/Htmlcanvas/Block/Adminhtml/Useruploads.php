<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Useruploads extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_useruploads';
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_headerText = Mage::helper('codevog_htmlcanvas')->__('View User Uploads');

        $this->_removeButton('add');
    }
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('codevog_htmlcanvas/adminhtml_useruploads_grid', 'useruploads.grid'));
        return parent::_prepareLayout();
    }

}