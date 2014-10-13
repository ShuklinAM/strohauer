<?php
class Codevog_News_Block_Controls extends Mage_Core_Block_Template
{


    public function __construct()
    {
        parent::__construct();

        $this->setTemplate('codevog/news/controls.phtml');
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $toolbar = $this->getToolbarBlock();

        // called prepare sortable parameters
        $collection = $this->getNewsCollection();

        $toolbar->setCollection($collection);

        $this->setChild('toolbar', $toolbar);
        return $this;
    }

    public function getToolbarBlock()
    {
        $block = $this->getLayout()->createBlock('codevog_news/toolbar', microtime());
        return $block;
    }

    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }
    public function getNewsCollection()
    {
        $news = Mage::getModel('news/news')->getCollection()
            ->addFieldToFilter('enabled', 1)
            ->addFieldToFilter('start_date', array('lteq' => date('Y-m-d H:i:s')))
            ->addFieldToFilter('finish_date', array('gteq' => date('Y-m-d H:i:s')))
            ->setOrder('start_date', 'desc');
        return $news;
    }

}
?>