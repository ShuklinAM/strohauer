<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Picsupload extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_picsupload';
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_headerText = Mage::helper('codevog_htmlcanvas')->__('View Pics');

        $this->_updateButton('add','label' , Mage::helper('codevog_htmlcanvas')->__('Add Pic'));
        $this->_updateButton('add','onclick' ,"setLocation('".$this->getUrl('*/*/addpicupload')."')" );

        //$this->_removeButton('add');
    }
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('codevog_htmlcanvas/adminhtml_picsupload_grid', 'picsupload.grid'));
        return parent::_prepareLayout();
    }

}