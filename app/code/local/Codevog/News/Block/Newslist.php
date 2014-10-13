<?php
class Codevog_News_Block_Newslist extends Mage_Catalog_Block_Product_Abstract//extends Mage_Core_Block_Template
{

    protected $_productCollection;

    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('codevog/news/newslist.phtml');
    }

    public function getNewsCollection()
    {
        ////get params

        $page = $_GET['p'];
        if(!$page)
            $page = 1;
        $num = $_GET['limit'];
        if(!$num)
            if($this->getMode() == 'list')
            {
                $num = Mage::getStoreConfig('catalog/frontend/list_per_page');
                if(!$num)
                    $num = 10;
            }
            else
            {
                $num = Mage::getStoreConfig('catalog/frontend/grid_per_page');
                if(!$num)
                    $num = 9;
            }

        $news = Mage::getModel('news/news')->getCollection()
            ->addFieldToFilter('enabled', 1)
            ->addFieldToFilter('start_date', array('lteq' => date('Y-m-d H:i:s')))
            ->addFieldToFilter('finish_date', array('gteq' => date('Y-m-d H:i:s')))
            ->setOrder('start_date', 'desc')
            ->setPageSize($num)
            ->setCurPage($page);

        $this->_productCollection = $news;

        return $news;
    }

    public function getMode()
    {
        $mode = $_GET['mode'];
        if(!$mode)
            $mode = Mage::getSingleton('catalog/session')->getDisplayMode();
        if(!$mode)
            $mode = 'grid';
        return $mode;
    }

    public function getToolbar()
    {
        return $this->getLayout()->getBlock('news.controls')->toHtml();
    }

}
?>