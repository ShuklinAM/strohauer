<?php
class Codevog_News_Block_Adminhtml_View extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_view';
        $this->_blockGroup = 'codevog_news';
        $this->_headerText = Mage::helper('codevog_news')->__('View news');

        $this->_addButton('addnews', array(
           'label'     => Mage::helper('codevog_news')->__('Add news'),
            'onclick'   => "setLocation('".$this->getUrl('*/*/addnews')."')", ));

        $this->_removeButton('add');
    }
    protected function _prepareLayout()
    {


        $this->setChild('grid', $this->getLayout()->createBlock('codevog_news/adminhtml_view_grid', 'news.grid'));
        return parent::_prepareLayout();
    }

}