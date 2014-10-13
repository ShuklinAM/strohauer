<?php
class Codevog_News_Block_Shownews extends Mage_Core_Block_Template
{

    public function _construct()
    {
        parent::_construct();
    }
    public function leftNewsActive()
    {
        return Mage::getStoreConfig('templatesettings/templatesettings_news/news_left');
    }
    public function getLeftNews()
    {
        $numOfLeftNews = $this->getNumOfLeftNews();

        $leftNews = Mage::getModel('news/news')->getCollection()
            ->addFieldToFilter('start_date', array('lteq' => date('Y-m-d H:i:s')))
            ->addFieldToFilter('finish_date', array('gteq' => date('Y-m-d H:i:s')))
            ->setOrder('start_date', 'desc')
            ->setPageSize($numOfLeftNews)
            ->setCurPage(1);
        return $leftNews;
    }
    public function getNumOfLeftNews()
    {
        return Mage::getStoreConfig('templatesettings/templatesettings_news/news_leftnum');
    }
    public function leftImagesActive()
    {
        return Mage::getStoreConfig('templatesettings/templatesettings_news/news_leftimage');
    }

    public function rightNewsActive()
    {
        return Mage::getStoreConfig('templatesettings/templatesettings_news/news_right');
    }
    public function getRightNews()
    {
        $numOfRightNews = $this->getNumOfRightNews();

        $rightNews = Mage::getModel('news/news')->getCollection()
            ->addFieldToFilter('start_date', array('lteq' => date('Y-m-d H:i:s')))
            ->addFieldToFilter('finish_date', array('gteq' => date('Y-m-d H:i:s')))
            ->setOrder('start_date', 'desc')
            ->setPageSize($numOfRightNews)
            ->setCurPage(1);
        return $rightNews;
    }
    public function getNumOfRightNews()
    {
        return Mage::getStoreConfig('templatesettings/templatesettings_news/news_rightnum');
    }
    public function rightImagesActive()
    {
        return Mage::getStoreConfig('templatesettings/templatesettings_news/news_rightimage');
    }

    public function homeNewsActive()
    {
        return Mage::getStoreConfig('templatesettings/templatesettings_news/news_home');
    }

    public function getNumOfHomeNews()
    {
        return Mage::getStoreConfig('templatesettings/templatesettings_news/news_homenum');
    }
    public function homeImagesActive()
    {
        return Mage::getStoreConfig('templatesettings/templatesettings_news/news_homeimage');
    }
    public function getHomeNews()
    {
        $numOfHomeNews = $this->getNumOfHomeNews();

        $homeNews = Mage::getModel('news/news')->getCollection()
            ->addFieldToFilter('enabled', 1)
            ->addFieldToFilter('start_date', array('lteq' => date('Y-m-d H:i:s')))
            ->addFieldToFilter('finish_date', array('gteq' => date('Y-m-d H:i:s')))
            ->setOrder('start_date', 'desc')
            ->setPageSize($numOfHomeNews)
            ->setCurPage(1);
        return $homeNews;
    }

}
?>